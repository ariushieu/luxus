<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_vi',
        'title_en',
        'subtitle_vi',
        'subtitle_en',
        'cloudinary_public_id',
        'cloudinary_url',
        'button_text_vi',
        'button_text_en',
        'button_link',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];
}
