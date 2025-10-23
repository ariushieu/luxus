<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'cloudinary_public_id',
        'cloudinary_url',
        'alt_text_vi',
        'alt_text_en',
        'is_primary',
        'display_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the project that owns the image
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
