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
     * Relationship with Trainer
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
