<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RescheduleRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'requested_by',
        'original_start_time',
        'new_start_time',
        'reason',
        'status'
    ];

    protected $casts = [
        'original_start_time' => 'datetime',
        'new_start_time' => 'datetime',
    ];

    /**
     * Relationship with Booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Relationship with Requester (User)
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
