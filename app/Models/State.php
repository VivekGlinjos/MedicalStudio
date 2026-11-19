<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'region',
        'cover_image',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: State has many colleges
     */
    public function colleges(): HasMany
    {
        return $this->hasMany(College::class, 'state_id', 'id');
    }

    /**
     * Get active colleges count for this state
     */
    public function getActiveCollegesCount()
    {
        return $this->colleges()->where('is_active', 1)->count();
    }
}
