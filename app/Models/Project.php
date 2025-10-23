<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title_vi',
        'title_en',
        'slug',
        'description_vi',
        'description_en',
        'content_vi',
        'content_en',
        'client_name',
        'location',
        'area',
        'year',
        'status',
        'is_featured',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'area' => 'decimal:2',
        'year' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the category that owns the project
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all images for the project
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class);
    }

    /**
     * Get the primary image
     */
    public function primaryImage()
    {
        return $this->hasOne(ProjectImage::class)->where('is_primary', true);
    }
}
