<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'booking_type',
        'schedule_id',
        'trainer_id',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Relationship with User (student)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Trainer
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    /**
     * Relationship with Schedule (for classes)
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Relationship with SessionReport
     */
    public function sessionReport()
    {
        return $this->hasOne(SessionReport::class);
    }

    /**
     * Relationship with RescheduleRequests
     */
    public function rescheduleRequests()
    {
        return $this->hasMany(RescheduleRequest::class);
    }
}
