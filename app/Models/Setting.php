<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value_vi',
        'value_en',
        'type',
        'group',
    ];

    /**
     * Get value by locale
     */
    public function getValueByLocale(string $locale = 'vi'): ?string
    {
        return $locale === 'en' ? $this->value_en : $this->value_vi;
    }
}
