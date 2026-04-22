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
        'target_area',
        'schedule_id',
        'trainer_id',
        'price',
        'payment_status',
        'start_time',
        'end_time',
        'status',
        'reschedule_status',
        'reschedule_reason',
        'reschedule_at',
        'report_content',
        'effort_rating',
        'session_intensity',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'reschedule_at' => 'datetime',
    ];

    /**
     * Relationship with User (student)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Subscription
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Relationship with Schedule (for classes)
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Relationship with Trainer (User model with role 'trainer')
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
