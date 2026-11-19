<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class College extends Model
{
    use HasFactory;

    protected $primaryKey = 'college_id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Resolve the public URL for a college image/banner field.
     *
     * Handles two storage conventions:
     *  1. Legacy bare filenames (e.g. "college_image_1711342717.jpeg")
     *     → stored at storage/app/public/college-images/image/{filename}
     *  2. New admin uploads with path (e.g. "colleges/abc.jpg")
     *     → stored at storage/app/public/{path}
     *
     * @param  string|null  $value     The raw DB column value
     * @param  string       $fallback  Fallback asset path when image is missing
     * @return string
     */
    protected function resolveImageUrl(?string $value, string $fallback): string
    {
        if (!$value) {
            return asset($fallback);
        }

        // If it already contains a directory separator it's a new admin upload path
        if (str_contains($value, '/')) {
            if (Storage::disk('public')->exists($value)) {
                return asset('storage/' . $value);
            }
            return asset($fallback);
        }

        // Legacy bare filename – look in the extracted directory, testing multiple common extensions
        $baseName = pathinfo($value, PATHINFO_FILENAME);
        $extensions = array_unique(array_filter([pathinfo($value, PATHINFO_EXTENSION), 'webp', 'jpg', 'jpeg', 'png']));
        
        foreach ($extensions as $ext) {
            $legacyPath = 'college-images/image/' . $baseName . '.' . $ext;
            if (Storage::disk('public')->exists($legacyPath)) {
                return asset('storage/' . $legacyPath);
            }
            $rootPath = 'colleges/' . $baseName . '.' . $ext;
            if (Storage::disk('public')->exists($rootPath)) {
                return asset('storage/' . $rootPath);
            }
        }

        return asset($fallback);
    }

    /**
     * Get the full public URL for the college profile image.
     */
    public function getImageUrl(): string
    {
        return $this->resolveImageUrl($this->college_image, 'images/default-college.png');
    }

    /**
     * Get the full public URL for the college banner.
     */
    public function getBannerUrl(): string
    {
        return $this->resolveImageUrl($this->college_banner, 'images/default-college.png');
    }

    /**
     * Check whether the college image file physically exists.
     */
    public function hasImage(): bool
    {
        return (bool) $this->college_image && $this->getImageUrl() !== asset('images/default-college.png');
    }

    /**
     * Check whether the college banner file physically exists.
     */
    public function hasBanner(): bool
    {
        return (bool) $this->college_banner && $this->getBannerUrl() !== asset('images/default-college.png');
    }

    protected $fillable = [
        'state_id',
        'college_type',
        'college_name',
        'slug',
        'college_image',
        'college_banner',
        'city',
        'place',
        'state',
        'about_us',
        'college_description',
        'courses',
        'year_of_inspection',
        'total_seats',
        'hospital_beds',
        'college_fees',
        'management_fee',
        'nri_fee',
        'website_link',
        'remarks',
        'general_rank',
        'obc_rank',
        'sc_rank',
        'st_rank',
        'cutoff_year',
        'category_cutoffs',
        'seo_text',
        'is_active',
        'created_by',
        'updated_by',
        'dean_email',
        'dean_contact',
        'principal_email',
        'principal_contact',
        'nodal_email',
        'nodal_contact',
        'extra_image_1',
        'extra_image_2',
        'extra_image_3',
    ];

    protected $casts = [
        'college_type' => 'integer',
        'is_active' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'state_id' => 'integer',
        'general_rank' => 'integer',
        'obc_rank' => 'integer',
        'sc_rank' => 'integer',
        'st_rank' => 'integer',
        'category_cutoffs' => 'array',
        'total_seats' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: College belongs to State
     */
    public function stateRelation(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    /**
     * Relationship: College has many galleries
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(CollegeGallery::class, 'college_id', 'college_id');
    }

    /**
     * Relationship: College has many cutoffs
     */
    public function cutoffs(): HasMany
    {
        return $this->hasMany(Cutoff::class, 'college_id', 'college_id');
    }

    /**
     * Relationship: College has many seat matrices
     */
    public function seatMatrices(): HasMany
    {
        return $this->hasMany(SeatMatrix::class, 'college_id', 'college_id');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeByState($query, $stateId)
    {
        return $query->where('state_id', $stateId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('college_type', $type);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('college_name', 'like', "%{$search}%")
                    ->orWhere('place', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
    }

    /**
     * Generate slug from college name
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = \Illuminate\Support\Str::slug($model->college_name);
            }
        });

        static::updating(function ($model) {
            if (!$model->slug) {
                $model->slug = \Illuminate\Support\Str::slug($model->college_name);
            }
        });

        // Auto-sync cutoffs and seat matrix when a college is saved
        static::saved(function ($college) {
            $year = 2025;

            // Sync rank columns → cutoffs table
            $rankMap = [
                'UR'  => 'general_rank',
                'OBC' => 'obc_rank',
                'SC'  => 'sc_rank',
                'ST'  => 'st_rank',
            ];

            foreach ($rankMap as $category => $column) {
                $rank = $college->$column;
                if (!empty($rank) && $rank > 0) {
                    Cutoff::updateOrCreate(
                        [
                            'college_id' => $college->college_id,
                            'course_id'  => 1,
                            'category'   => $category,
                            'quota'      => 'AIQ',
                            'year'       => $year,
                            'round'      => 'Final Round',
                        ],
                        ['closing_rank' => (int) $rank]
                    );
                }
            }

            // Sync total_seats → seat_matrices table
            if (!empty($college->total_seats) && $college->total_seats > 0) {
                SeatMatrix::updateOrCreate(
                    [
                        'college_id' => $college->college_id,
                        'course_id'  => 1,
                        'category'   => 'UR',
                        'quota'      => 'AIQ',
                    ],
                    ['total_seats' => (int) $college->total_seats]
                );
            }
        });
    }

    /**
     * Get college type label
     */
    public function getTypeLabel(): string
    {
        return match($this->college_type) {
            0 => 'Government',
            1 => 'Private',
            2 => 'Deemed',
            3 => 'Central',
            default => 'Unknown',
        };
    }

    /**
     * Get college status label
     */
    public function getStatusLabel(): string
    {
        return $this->is_active == 1 ? 'Active' : 'Inactive';
    }
}
