<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\College;
use App\Models\Cutoff;
use App\Models\SeatMatrix;
use App\Models\State;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ImportClientCollegeData extends Command
{
    protected $signature = 'import:client-data 
                            {--file= : Path to extracted_sheets.json or xlsx} 
                            {--dry-run : Preview changes without writing to database}
                            {--sheet= : Process only a specific sheet}';

    protected $description = 'Import and deduplicate comprehensive college data, cutoffs (2024 & 2025), seats, and institutional contacts from client Excel workbook';

    private $stateCache = [];
    private $allCollegesCache;

    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');
        $sheetFilter = $this->option('sheet');

        $jsonFile = $this->option('file') ?: database_path('data/extracted_sheets.json');

        if (!file_exists($jsonFile)) {
            $this->error("Data file not found at: {$jsonFile}");
            $this->info("Extracting from database/data/colleges_cutoff_data.xlsx first...");
            $script = base_path('../../../../../Users/Glinjos/.gemini/antigravity/brain/9678b7b0-5a23-49ae-b872-b6a42ef29006/scratch/parse_excel_to_json.py');
            if (file_exists($script)) {
                shell_exec("python \"{$script}\"");
            }
            if (!file_exists($jsonFile)) {
                $this->error("Could not locate extracted_sheets.json.");
                return self::FAILURE;
            }
        }

        $this->info("Loading data from: {$jsonFile}" . ($isDryRun ? " (DRY RUN MODE)" : ""));
        $sheetsData = json_decode(file_get_contents($jsonFile), true);

        if (!$sheetsData || !is_array($sheetsData)) {
            $this->error("Invalid JSON format in {$jsonFile}");
            return self::FAILURE;
        }

        // Cache states
        $this->stateCache = State::all()->keyBy(function($s) {
            return strtolower(trim($s->name));
        });

        // Ensure MBBS course exists
        $mbbs = Course::firstOrCreate(
            ['slug' => 'mbbs'],
            ['name' => 'MBBS', 'level' => 'UG', 'duration' => '5.5 Years']
        );
        $courseId = $mbbs->id;

        // Cache all existing colleges
        $this->allCollegesCache = College::all();

        $stats = [
            'colleges_matched' => 0,
            'colleges_created' => 0,
            'cutoffs_updated' => 0,
            'cutoffs_created' => 0,
            'duplicates_deactivated' => 0,
        ];

        // Process each sheet
        foreach ($sheetsData as $sheetName => $rows) {
            if ($sheetFilter && strtolower($sheetFilter) !== strtolower($sheetName)) {
                continue;
            }

            if (empty($rows) || count($rows) < 2) {
                continue;
            }

            $this->line("────────────────────────────────────────────────────────────");
            $this->info("Processing sheet: {$sheetName} (" . (count($rows) - 1) . " rows)");

            $stateId = $this->resolveStateId($sheetName);
            $defaultType = $this->resolveDefaultType($sheetName);

            $headers = $rows[0];
            $colMapping = $this->mapHeaders($headers);

            $collegeRows = array_slice($rows, 1);

            foreach ($collegeRows as $row) {
                $rawCollegeName = $this->cleanText($row['A'] ?? '');
                if (empty($rawCollegeName)) continue;

                $defaultType = $this->resolveDefaultType($sheetName);

                // Match or find college
                $college = $this->findCollege($rawCollegeName, $stateId, $defaultType);

                $collegeData = $this->extractCollegeMetadata($row, $colMapping, $rawCollegeName, $stateId, $defaultType);

                if ($college) {
                    $stats['colleges_matched']++;
                    $this->line("  ✓ Matched: <info>{$rawCollegeName}</info> -> ID [{$college->college_id}] {$college->college_name}");

                    if (!$isDryRun) {
                        // Keep existing image & banner if new ones are empty
                        if ($college->college_image) unset($collegeData['college_image']);
                        if ($college->college_banner) unset($collegeData['college_banner']);

                        // Consolidate duplicates
                        $duplicatesDeactivated = $this->cleanupDuplicateColleges($college, $rawCollegeName, $stateId);
                        $stats['duplicates_deactivated'] += $duplicatesDeactivated;

                        College::withoutEvents(function() use ($college, $collegeData) {
                            $college->update($collegeData);
                        });
                    }
                } else {
                    $stats['colleges_created']++;
                    $this->line("  + New College: <comment>{$rawCollegeName}</comment>");

                    if (!$isDryRun) {
                        $college = College::withoutEvents(function() use ($collegeData) {
                            return College::create($collegeData);
                        });
                        $this->allCollegesCache->push($college);
                    }
                }

                // Process Cutoffs for this college
                $categoryCutoffs = [];
                foreach ($colMapping['cutoffs'] as $colLetter => $meta) {
                    $val = trim((string)($row[$colLetter] ?? ''));
                    $rank = (int)preg_replace('/[^0-9]/', '', $val);

                    if ($rank > 0 && $rank < 2500000) {
                        $year = $meta['year'];
                        $quota = $meta['quota'];
                        $category = $meta['category'];

                        // Track 2025 cutoffs for JSON dictionary
                        if ($year === 2025) {
                            $categoryCutoffs[$category] = $rank;
                        }

                        if (!$isDryRun && $college) {
                            $cutoffRecord = Cutoff::updateOrCreate(
                                [
                                    'college_id' => $college->college_id,
                                    'course_id'  => $courseId,
                                    'year'       => $year,
                                    'round'      => 'Final Round',
                                    'quota'      => $quota,
                                    'category'   => $category,
                                ],
                                [
                                    'closing_rank' => $rank,
                                ]
                            );

                            if ($cutoffRecord->wasRecentlyCreated) {
                                $stats['cutoffs_created']++;
                            } else {
                                $stats['cutoffs_updated']++;
                            }
                        }
                    }
                }

                // Update category_cutoffs JSON on college
                if (!$isDryRun && $college && !empty($categoryCutoffs)) {
                    College::withoutEvents(function() use ($college, $categoryCutoffs) {
                        $current = $college->category_cutoffs ?: [];
                        $merged = array_merge($current, $categoryCutoffs);
                        $college->update(['category_cutoffs' => $merged]);
                    });
                }

                // Update Seat Matrix
                if (!$isDryRun && $college && !empty($collegeData['total_seats'])) {
                    SeatMatrix::updateOrCreate(
                        [
                            'college_id' => $college->college_id,
                            'course_id'  => $courseId,
                            'category'   => 'UR',
                            'quota'      => 'AIQ',
                        ],
                        [
                            'total_seats' => (int)$collegeData['total_seats'],
                        ]
                    );
                }
            }
        }

        $this->newLine();
        $this->info("════════════════════════════════════════════════════════════");
        $this->info("                IMPORT SUMMARY                             ");
        $this->info("════════════════════════════════════════════════════════════");
        $this->table(
            ['Metric', 'Count'],
            [
                ['Colleges Matched & Updated', $stats['colleges_matched']],
                ['New Colleges Created',       $stats['colleges_created']],
                ['Duplicate Records Handled',  $stats['duplicates_deactivated']],
                ['Cutoff Records Created',     $stats['cutoffs_created']],
                ['Cutoff Records Updated',     $stats['cutoffs_updated']],
            ]
        );

        return self::SUCCESS;
    }

    /**
     * Map sheet headers to metadata and cutoff descriptors.
     */
    private function mapHeaders(array $headers): array
    {
        $mapping = [
            'type' => null,
            'state' => null,
            'city' => null,
            'location' => null,
            'course' => null,
            'fees_display' => null,
            'management_fee' => null,
            'nri_fee' => null,
            'total_seats' => null,
            'bed_capacity' => null,
            'college_website' => null,
            'dean_name' => null,
            'dean_email' => null,
            'dean_contact' => null,
            'principal_name' => null,
            'principal_email' => null,
            'principal_contact' => null,
            'nodal_name' => null,
            'nodal_email' => null,
            'nodal_contact' => null,
            'cutoffs' => [],
        ];

        foreach ($headers as $colLetter => $rawH) {
            $h = strtoupper($this->cleanText($rawH));
            if (empty($h)) continue;

            if ($colLetter === 'B' || preg_match('/^TYPE$/', $h)) {
                $mapping['type'] = $colLetter;
            } elseif ($colLetter === 'C' || preg_match('/^STATE$/', $h)) {
                $mapping['state'] = $colLetter;
            } elseif ($colLetter === 'D' || preg_match('/^CITY$/', $h)) {
                $mapping['city'] = $colLetter;
            } elseif ($colLetter === 'E' || preg_match('/^(LOCATION|PLACE)$/', $h)) {
                $mapping['location'] = $colLetter;
            } elseif ($colLetter === 'F' || preg_match('/^COURSE$/', $h)) {
                $mapping['course'] = $colLetter;
            } elseif (preg_match('/FEES?(\s+|_)?DISPLAY/i', $h) || preg_match('/^FEE(\s+|_)?DISPLAY$/i', $h)) {
                $mapping['fees_display'] = $colLetter;
            } elseif (preg_match('/MANAGEMENT(\s+|_)?FEE/i', $h)) {
                $mapping['management_fee'] = $colLetter;
            } elseif (preg_match('/NRI(\s+|_)?FEE/i', $h)) {
                $mapping['nri_fee'] = $colLetter;
            } elseif (preg_match('/TOTAL(\s+|_)?SEATS/i', $h)) {
                $mapping['total_seats'] = $colLetter;
            } elseif (preg_match('/BED(\s+|_)?CAPACITY/i', $h) || preg_match('/HOSPITAL(\s+|_)?BEDS/i', $h)) {
                $mapping['bed_capacity'] = $colLetter;
            } elseif (preg_match('/(COLLEGE(\s+|_)?WEBSITE|WEBSITE)/i', $h)) {
                $mapping['college_website'] = $colLetter;
            } elseif (preg_match('/DEAN(\s+|_)?EMAIL/i', $h)) {
                $mapping['dean_email'] = $colLetter;
            } elseif (preg_match('/DEAN(\s+|_)?(CONTACT|NUMBER|PHONE)/i', $h)) {
                $mapping['dean_contact'] = $colLetter;
            } elseif (preg_match('/(PRINCIPAL|PRINCIPLE)(\s+|_)?EMAIL/i', $h)) {
                $mapping['principal_email'] = $colLetter;
            } elseif (preg_match('/(PRINCIPAL|PRINCIPLE)(\s+|_)?(CONTACT|NUMBER|PHONE)/i', $h)) {
                $mapping['principal_contact'] = $colLetter;
            } elseif (preg_match('/NODAL(\s+|_)?(OFFICER(\s+|_)?|)EMAIL/i', $h)) {
                $mapping['nodal_email'] = $colLetter;
            } elseif (preg_match('/NODAL(\s+|_)?(OFFICER(\s+|_)?|)(CONTACT|NUMBER|PHONE)/i', $h)) {
                $mapping['nodal_contact'] = $colLetter;
            } elseif (preg_match('/\b(2024|2025)\b/', $h)) {
                // Cutoff Column
                $meta = $this->parseCutoffHeader($h);
                if ($meta) {
                    $mapping['cutoffs'][$colLetter] = $meta;
                }
            }
        }

        return $mapping;
    }

    /**
     * Parse column header into [year, quota, category].
     */
    private function parseCutoffHeader(string $h): ?array
    {
        $year = 2025;
        if (preg_match('/\b(2024|2025)\b/', $h, $ym)) {
            $year = (int)$ym[1];
        }

        $quota = 'AIQ';
        if (str_contains($h, 'MANAGEMENT') || str_contains($h, 'MGT') || str_contains($h, 'MQ') || str_contains($h, 'CAT B')) {
            $quota = 'Management';
        } elseif (str_contains($h, 'NRI')) {
            $quota = 'NRI';
        } elseif (str_contains($h, 'DEEMED')) {
            $quota = 'Deemed';
        } elseif (str_contains($h, 'MINORITY')) {
            $quota = 'Minority';
        } elseif (str_contains($h, 'AIIMS') || str_contains($h, 'CENTRAL') || str_contains($h, 'JIPMER')) {
            $quota = 'Central';
        } elseif (str_contains($h, 'STATE') || str_contains($h, 'GOVT QUOTA') || str_contains($h, 'GOVT SEAT') || str_contains($h, 'LOCAL') || str_contains($h, 'HILLY') || str_contains($h, 'DEFENCE') || str_contains($h, 'SCHOOL') || str_contains($h, 'SPORTS')) {
            $quota = 'State';
        }

        // Clean category name
        $cat = $h;
        $cat = preg_replace('/\b(2024|2025)\b/', '', $cat);
        $cat = preg_replace('/^(AIR|STATE|GOVT|QUOTA|LOCAL|SEATS|SEAT|PUNJAB|ASSAM|JHARKHAND|MEGHALAYA|TRIPURA|J&K|JIPMER|AIIMS|PONDICHERRY|HP|TN)\s+/i', '', $cat);
        $cat = preg_replace('/\b(RANK|QUOTA|SEATS|SEAT)\b/i', '', $cat);
        $cat = trim(preg_replace('/\s+/', ' ', $cat));
        if (empty($cat)) $cat = 'UR';

        // Canonical Category Mapping
        if (in_array($cat, ['GENERAL', 'GEN', 'OPEN', 'UR', 'GENERAK'])) {
            $cat = 'UR';
        }

        return [
            'year' => $year,
            'quota' => $quota,
            'category' => $cat,
            'header' => $h,
        ];
    }

    /**
     * Extract attributes to update in colleges table.
     */
    private function extractCollegeMetadata(array $row, array $map, string $rawName, int $stateId, int $defaultType): array
    {
        $city = $this->cleanText($row[$map['city'] ?? ''] ?? '');
        $place = $this->cleanText($row[$map['location'] ?? ''] ?? '');
        $stateName = $this->cleanText($row[$map['state'] ?? ''] ?? '');

        $typeVal = $this->cleanText($row[$map['type'] ?? ''] ?? '');
        $collegeType = $this->mapCollegeType($typeVal, $defaultType);

        $feesDisplay = $this->cleanText($row[$map['fees_display'] ?? ''] ?? '');
        $managementFee = $this->cleanText($row[$map['management_fee'] ?? ''] ?? '');
        $nriFee = $this->cleanText($row[$map['nri_fee'] ?? ''] ?? '');

        $totalSeats = (int)preg_replace('/[^0-9]/', '', (string)($row[$map['total_seats'] ?? ''] ?? ''));
        $hospitalBeds = (int)preg_replace('/[^0-9]/', '', (string)($row[$map['bed_capacity'] ?? ''] ?? ''));

        $website = $this->cleanText($row[$map['college_website'] ?? ''] ?? '');

        // Contacts - Dean
        $deanEmail = $this->extractEmail($row[$map['dean_email'] ?? ''] ?? '');
        $deanContact = $this->cleanContact($row[$map['dean_contact'] ?? ''] ?? '');

        // Contacts - Principal
        $principalEmail = $this->extractEmail($row[$map['principal_email'] ?? ''] ?? '');
        $principalContact = $this->cleanContact($row[$map['principal_contact'] ?? ''] ?? '');

        // Contacts - Nodal Officer
        $nodalEmail = $this->extractEmail($row[$map['nodal_email'] ?? ''] ?? '');
        $nodalContact = $this->cleanContact($row[$map['nodal_contact'] ?? ''] ?? '');

        // Extract 2025 AIQ summary ranks
        $generalRank = null;
        $obcRank = null;
        $scRank = null;
        $stRank = null;

        foreach ($map['cutoffs'] as $colLetter => $meta) {
            if ($meta['year'] === 2025 && $meta['quota'] === 'AIQ') {
                $val = (int)preg_replace('/[^0-9]/', '', (string)($row[$colLetter] ?? ''));
                if ($val > 0) {
                    if ($meta['category'] === 'UR' && !$generalRank) $generalRank = $val;
                    if ($meta['category'] === 'OBC' && !$obcRank) $obcRank = $val;
                    if ($meta['category'] === 'SC' && !$scRank) $scRank = $val;
                    if ($meta['category'] === 'ST' && !$stRank) $stRank = $val;
                }
            }
        }

        $data = [
            'college_name' => $rawName,
            'slug'         => Str::slug($rawName),
            'state_id'     => $stateId,
            'college_type' => $collegeType,
            'city'         => $city ?: null,
            'place'        => $place ?: null,
            'state'        => $stateName ?: null,
            'courses'      => 'MBBS',
            'college_fees' => $feesDisplay ?: null,
            'management_fee' => $managementFee ?: null,
            'nri_fee'      => $nriFee ?: null,
            'website_link' => $website ?: null,
            'total_seats'  => $totalSeats > 0 ? $totalSeats : null,
            'hospital_beds'=> $hospitalBeds > 0 ? $hospitalBeds : null,
            'dean_email'   => $deanEmail ?: null,
            'dean_contact' => $deanContact ?: null,
            'principal_email' => $principalEmail ?: null,
            'principal_contact' => $principalContact ?: null,
            'nodal_email'  => $nodalEmail ?: null,
            'nodal_contact'=> $nodalContact ?: null,
            'cutoff_year'  => '2025',
            'is_active'    => 1,
        ];

        if ($generalRank) $data['general_rank'] = $generalRank;
        if ($obcRank) $data['obc_rank'] = $obcRank;
        if ($scRank) $data['sc_rank'] = $scRank;
        if ($stRank) $data['st_rank'] = $stRank;

        return array_filter($data, fn($v) => !is_null($v));
    }

    /**
     * Find an existing college using tiered matching with type filtering and token matching.
     */
    private function findCollege(string $rawName, int $stateId, int $defaultType = 0): ?College
    {
        // 1. Exact name match
        $found = $this->allCollegesCache->firstWhere('college_name', $rawName);
        if ($found) return $found;

        // 2. Normalized match in same state
        $norm = $this->normalizeName($rawName);
        $found = $this->allCollegesCache->where('state_id', $stateId)->first(function($c) use ($norm) {
            return $this->normalizeName($c->college_name) === $norm;
        });
        if ($found) return $found;

        // 3. Slug match
        $slug = Str::slug($rawName);
        $found = $this->allCollegesCache->firstWhere('slug', $slug);
        if ($found) return $found;

        // Filter state candidates by college_type (Govt vs Private/Deemed) to avoid cross-matching
        $stateCandidates = $this->allCollegesCache->where('state_id', $stateId);
        $typeCandidates = $stateCandidates->filter(function($c) use ($defaultType) {
            // Group Govt (0, 3) vs Private/Deemed (1, 2)
            $isGovt = in_array($c->college_type, [0, 3]);
            $wantGovt = in_array($defaultType, [0, 3]);
            return $isGovt === $wantGovt;
        });

        $candidatesToSearch = $typeCandidates->isNotEmpty() ? $typeCandidates : $stateCandidates;

        // 4. Distinctive keyword match ONLY on college_name
        $keyTokens = $this->extractDistinctiveTokens($rawName);
        if (!empty($keyTokens)) {
            $bestCollege = null;
            $bestScore = 0;

            foreach ($candidatesToSearch as $c) {
                $cTokens = $this->extractDistinctiveTokens($c->college_name);
                $common = array_intersect($keyTokens, $cTokens);
                $score = count($common);

                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestCollege = $c;
                }
            }

            if ($bestCollege && $bestScore >= count($keyTokens) * 0.5) {
                return $bestCollege;
            }
        }

        // 5. String similarity on distinctive tokens
        $distinctiveName = implode(' ', $keyTokens);
        if (!empty($distinctiveName)) {
            $bestSim = 0;
            $bestSimCollege = null;
            foreach ($candidatesToSearch as $c) {
                $cDistinctive = implode(' ', $this->extractDistinctiveTokens($c->college_name));
                similar_text($distinctiveName, $cDistinctive, $pct);
                if ($pct > $bestSim && $pct >= 70) {
                    $bestSim = $pct;
                    $bestSimCollege = $c;
                }
            }
            if ($bestSimCollege) return $bestSimCollege;
        }

        return null;
    }

    private function extractDistinctiveTokens(string $name): array
    {
        $stopWords = [
            'government', 'govt', 'medical', 'college', 'collegle', 'collge',
            'hospital', 'institute', 'instt', 'inst', 'sciences', 'science',
            'research', 'centre', 'center', 'and', 'of', '&', 'society',
            'trust', 'memorial', 'general', 'super', 'specialty', 'speciality',
            'district', 'the', 'taluk', 'mandal', 'deemed', 'university', 'pvt', 'private'
        ];

        $cleaned = strtolower(preg_replace('/[^a-zA-Z0-9]/', ' ', $name));
        $tokens = array_filter(explode(' ', $cleaned));

        $filtered = [];
        foreach ($tokens as $t) {
            if (strlen($t) > 2 && !in_array($t, $stopWords)) {
                $filtered[] = $t;
            }
        }

        return array_values($filtered);
    }

    /**
     * Consolidate duplicate records for this college.
     */
    private function cleanupDuplicateColleges(College $master, string $rawName, int $stateId): int
    {
        $norm = $this->normalizeName($rawName);
        $keyTokens = $this->extractDistinctiveTokens($rawName);

        $duplicates = College::where('college_id', '!=', $master->college_id)
            ->where('state_id', $stateId)
            ->get()
            ->filter(function($c) use ($norm, $keyTokens) {
                if ($this->normalizeName($c->college_name) === $norm) {
                    return true;
                }
                if (!empty($keyTokens)) {
                    $cTokens = $this->extractDistinctiveTokens($c->college_name);
                    $common = array_intersect($keyTokens, $cTokens);
                    return count($common) > 0 && count($common) >= count($keyTokens) * 0.7;
                }
                return false;
            });

        $count = 0;
        foreach ($duplicates as $dup) {
            // Re-point any cutoffs or choices that were attached to the duplicate
            Cutoff::where('college_id', $dup->college_id)->update(['college_id' => $master->college_id]);
            SeatMatrix::where('college_id', $dup->college_id)->update(['college_id' => $master->college_id]);
            DB::table('choices')->where('college_id', $dup->college_id)->update(['college_id' => $master->college_id]);

            // If duplicate has an image while master doesn't, rescue the image!
            if ($dup->college_image && !$master->college_image) {
                $master->college_image = $dup->college_image;
                $master->college_banner = $dup->college_banner;
                $master->saveQuietly();
            }

            // Deactivate duplicate
            $dup->update(['is_active' => 0]);
            $count++;
        }

        return $count;
    }

    private function normalizeName(string $name): string
    {
        $str = $this->cleanText($name);
        $str = preg_replace('/\([^)]*\)/', '', $str);
        $str = preg_replace('/[^a-zA-Z0-9]/', ' ', strtolower($str));
        $str = str_replace(
            ['collge', 'collegle', 'govt', 'instt', 'inst', 'medicalcollege'],
            ['college', 'college', 'government', 'institute', 'institute', 'medical college'],
            $str
        );
        return trim(preg_replace('/\s+/', ' ', $str));
    }

    private function cleanText(?string $str): string
    {
        if (!$str) return '';
        $str = str_replace(["\xc2\xa0", "\xa0"], ' ', $str);
        return trim(preg_replace('/\s+/', ' ', $str));
    }

    private function extractEmail(?string $str): ?string
    {
        if (!$str) return null;
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $str, $m)) {
            return $m[0];
        }
        return null;
    }

    private function cleanContact(?string $str): ?string
    {
        if (!$str) return null;
        $cleaned = trim(str_replace(["\r", "\n"], ', ', $str));
        return substr($cleaned, 0, 255);
    }

    private function mapCollegeType(string $typeStr, int $defaultType): int
    {
        $t = strtolower(trim($typeStr));
        if (str_contains($t, 'cent')) return 3;
        if (str_contains($t, 'deem')) return 2;
        if (str_contains($t, 'priv')) return 1;
        if (str_contains($t, 'gov')) return 0;
        return $defaultType;
    }

    private function resolveDefaultType(string $sheet): int
    {
        if (str_contains($sheet, '_pvt')) return 1;
        if (str_contains($sheet, 'deemed')) return 2;
        if (str_contains($sheet, 'central')) return 3;
        return 0; // default govt
    }

    private function resolveStateId(string $sheet): int
    {
        $mapping = [
            'kerala' => 'Kerala',
            'tamil_nadu' => 'Tamil Nadu',
            'karnataka' => 'Karnataka',
            'andra_pradesh' => 'Andhra Pradesh',
            'telangana' => 'Telangana',
            'uttarakhand' => 'Uttarakhand',
            'bihar' => 'Bihar',
            'jharkhand' => 'Jharkhand',
            'gujarath' => 'Gujarat',
            'meghalaya' => 'Meghalaya',
            'arunachal_pradesh' => 'Arunachal Pradesh',
            'chandigrah' => 'Chandigarh',
            'delhi' => 'Delhi',
            'tripura' => 'Tripura',
            'rajasthan' => 'Rajasthan',
            'haryana' => 'Haryana',
            'chattisgrah' => 'Chhattisgarh',
            'himachal_pradesh' => 'Himachal',
            'odissa' => 'Odisha',
            'madhya_pradesh' => 'Madhya Pradesh',
            'maharastra' => 'Maharashtra',
            'sikkim' => 'Sikkim',
            'goa' => 'Goa',
            'manipur' => 'Manipur',
            'uttarpradesh' => 'Uttar Pradesh',
            'jammu_kashmir' => 'Jammu & Kashmir',
            'punjab' => 'Punjab',
            'mizoram' => 'Mizoram',
            'west_bengal' => 'West Bengal',
            'assam' => 'Assam',
            'puducherry' => 'Pondicherry',
            'nagaland' => 'Nagaland',
            'andaman_nicobar' => 'Andaman & Nicobar',
            'dadra_nagar_haveli' => 'Dadra & Nagar Haveli',
        ];

        foreach ($mapping as $key => $name) {
            if (str_starts_with($sheet, $key)) {
                $st = $this->stateCache->get(strtolower($name));
                if ($st) return $st->id;
                $newSt = State::firstOrCreate(['name' => $name]);
                $this->stateCache->put(strtolower($name), $newSt);
                return $newSt->id;
            }
        }

        return 1; // Fallback to Kerala
    }
}
