<?php

namespace App\Http\Controllers;

class CounsellingController extends Controller
{
    public function show(string $type)
    {
        $data = $this->getTypeData($type);
        return view('counselling', compact('type', 'data'));
    }

    private function getTypeData(string $type): array
    {
        $map = [
            'neet-pg' => [
                'name'       => 'NEET PG',
                'full_name'  => 'National Eligibility cum Entrance Test – Post Graduate',
                'icon'       => 'fa-user-doctor',
                'color'      => '#E11D48',
                'tagline'    => 'Navigate NEET-PG 2026 with Data-Driven Confidence',
                'desc'       => 'Complete guidance for MD, MS, and DNB aspirants through All India Quota (50%), Deemed Universities (100%), and Central Universities counselling.',
                'rounds'     => ['Registration', 'Choice Filling', 'Choice Locking', 'Allotment 1', 'Allotment 2', 'Allotment 3', 'Stray Vacancy Round', 'Mop-up Round'],
                'seats'      => '45,540+ seats across India',
                'institutes' => '684 medical colleges',
                'price'      => '₹1,499',
                'features'   => ['Rank Scan & Prediction Engine', 'Live Seat Matrix (Clear-cut + Virtual)', 'Allotment Mapping', 'Choice List Builder', 'NRI/OCI Documentation Guide', '24/7 Expert Helpline'],
            ],
            'neet-ug' => [
                'name'       => 'NEET UG',
                'full_name'  => 'National Eligibility cum Entrance Test – Under Graduate',
                'icon'       => 'fa-graduation-cap',
                'color'      => '#3B82F6',
                'tagline'    => 'Your Complete NEET-UG 2026 Counselling Guide',
                'desc'       => 'Navigate the largest medical entrance in India. Coverage of All India Quota (15%), State Quota (85%), Deemed Universities, and Central Institutions for MBBS and BDS admissions.',
                'rounds'     => ['Registration', 'Choice Filling', 'Choice Locking', 'Allotment 1', 'Allotment 2', 'Allotment 3', 'Stray Vacancy Round', 'Mop-up Round'],
                'seats'      => '1,29,603 MBBS & 28,016 BDS',
                'institutes' => '824 Medical & 329 Dental',
                'price'      => '₹1,499',
                'features'   => ['All India + State Counselling Coverage', 'Live Seat Matrix', 'State Rank Correlation', 'Choice List Builder', 'Closing Rank Trends', 'Live Critical Alerts'],
            ],
            'neet-mds' => [
                'name'       => 'NEET MDS',
                'full_name'  => 'National Eligibility cum Entrance Test – Master of Dental Surgery',
                'icon'       => 'fa-tooth',
                'color'      => '#8B5CF6',
                'tagline'    => 'Master Your NEET-MDS Counselling Strategy',
                'desc'       => 'Comprehensive coverage for MDS aspirants. Orthodontics, Oral Surgery, Prosthodontics, Periodontics and all specialties — data-verified closing ranks.',
                'rounds'     => ['Registration', 'Choice Filling', 'Choice Locking', 'Allotment 1', 'Allotment 2', 'Allotment 3', 'Stray Vacancy Round', 'Mop-up Round'],
                'seats'      => '6,000+ MDS seats',
                'institutes' => '320+ dental colleges',
                'price'      => '₹1,499',
                'features'   => ['Specialty-wise Closing Ranks', 'Deemed University Coverage', 'Choice List Builder', 'Fee & Bond Transparency', 'Live Updates', 'Expert Guidance Add-on'],
            ],
            'inicet' => [
                'name'       => 'INICET',
                'full_name'  => 'Institute of National Importance Combined Entrance Test',
                'icon'       => 'fa-microscope',
                'color'      => '#10B981',
                'tagline'    => 'INICET 2026 — Navigate AIIMS & PGIMER Counselling',
                'desc'       => 'The gateway to AIIMS, PGIMER, JIPMER, and NIMHANS. Navigate the most prestigious postgraduate medical admissions with clinical-grade data.',
                'rounds'     => ['Registration', 'Seat Allotment Round 1', 'Seat Allotment Round 2'],
                'seats'      => '1,500+ seats at INIs',
                'institutes' => 'AIIMS, PGIMER, JIPMER, NIMHANS',
                'price'      => '₹1,499',
                'features'   => ['Institute-wise Closing Ranks', 'Specialty Preference Optimizer', 'Live Alerts on Schedule', 'Expert Guidance', 'Choice List Templates', 'Document Checklist'],
            ],
            'dnb-pdcet' => [
                'name'       => 'DNB PDCET',
                'full_name'  => 'Diplomate of National Board – Post Diploma Centralised Entrance Test',
                'icon'       => 'fa-file-medical',
                'color'      => '#F59E0B',
                'tagline'    => 'DNB PDCET 2026 — Your Complete Strategy Guide',
                'desc'       => 'Navigate DNB admissions at accredited hospitals across India. Track seat availability, closing ranks, and hospital quality data.',
                'rounds'     => ['Registration & Payment', 'Choice Filling', 'Result & Joining'],
                'seats'      => '4,000+ DNB seats',
                'institutes' => '2,000+ accredited hospitals',
                'price'      => '₹1,499',
                'features'   => ['Hospital-wise Closing Ranks', 'Seat Matrix Tracker', 'Stipend Data', 'Bond Details', 'Choice List Builder', 'Live Schedule Alerts'],
            ],
            'neet-ss' => [
                'name'       => 'NEET SS',
                'full_name'  => 'National Eligibility cum Entrance Test – Super Specialty',
                'icon'       => 'fa-star',
                'color'      => '#0C1929',
                'tagline'    => 'NEET SS 2026 — Super Specialty Counselling Guide',
                'desc'       => 'The final step toward super specialty. Navigate DM and MCh admissions with granular closing rank data and specialty-specific strategy.',
                'rounds'     => ['Registration', 'Choice Filling', 'Choice Locking', 'Allotment 1', 'Allotment 2', 'Allotment 3', 'Stray Vacancy Round', 'Mop-up Round'],
                'seats'      => '2,000+ DM/MCh seats',
                'institutes' => '150+ institutes',
                'price'      => '₹1,499',
                'features'   => ['Specialty-wise Closing Ranks', 'Institute Profiles', 'Live Allotment Map', 'Choice Builder', 'Document Checklist', 'Free Basic Access'],
            ],
        ];
        return $map[$type] ?? $map['neet-pg'];
    }
}
