<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trainer_id',
        'weight',
        'bmi',
        'fat_percent',
        'recorded_by'
    ];

    /**
     * Relationship with User (student)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Trainer (User model)
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
