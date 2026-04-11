<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'trainer_id',
        'user_id',
        'notes',
        'effort_rating',
        'session_intensity'
    ];

    /**
     * Relationship with Booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Relationship with Trainer
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    /**
     * Relationship with User (student)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
