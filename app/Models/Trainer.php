<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'is_available',
        'price_per_session',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Schedules
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function healthMetrics()
    {
        return $this->hasMany(HealthMetric::class);
    }

    public function sessionReports()
    {
        return $this->hasMany(SessionReport::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
