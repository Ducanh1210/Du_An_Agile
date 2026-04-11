<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_id',
        'trainer_id',
        'start_date',
        'end_date',
        'final_price',
        'pt_sessions_left',
        'status',
        'cancel_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Membership
     */
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    /**
     * Relationship with Trainer
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
