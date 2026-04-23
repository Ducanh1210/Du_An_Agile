<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'trainer_id',
        'start_time',
        'end_time',
        'capacity',
        'current_enrolled',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Relationship with Trainer (User model with role 'trainer')
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * Check if class is full
     */
    public function isFull()
    {
        return $this->current_enrolled >= $this->capacity;
    }

    /**
     * Check if class is new (created within 48 hours)
     */
    public function isNew()
    {
        return $this->created_at >= now()->subHours(48);
    }

    /**
     * Check if class is popular (enrolled >= 80% capacity)
     */
    public function isPopular()
    {
        return $this->current_enrolled >= ($this->capacity * 0.8);
    }

    /**
     * Get visual color for category
     */
    public function getCategoryColor()
    {
        return match($this->category) {
            'bodybuilding' => 'orange',
            'yoga' => 'indigo',
            default => 'slate',
        };
    }
}
