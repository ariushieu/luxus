<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'project_type',
        'budget',
        'area',
        'request_details',
        'status',
        'admin_notes',
        'quoted_amount',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'area' => 'decimal:2',
        'quoted_amount' => 'decimal:2',
    ];

    /**
     * Scope for pending quotes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for reviewing quotes
     */
    public function scopeReviewing($query)
    {
        return $query->where('status', 'reviewing');
    }
}
