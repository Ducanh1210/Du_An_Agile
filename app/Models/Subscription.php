<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'frozen_until',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'cancelled_at' => 'datetime',
        'frozen_until' => 'date',
        'final_price' => 'decimal:2',
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
     * Relationship with Trainer (now integrated into User)
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id')->where('role', 'trainer');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->end_date->isFuture();
    }

    public function isFrozen(): bool
    {
        return $this->status === 'frozen' ||
               ($this->frozen_until && Carbon::parse($this->frozen_until)->isFuture());
    }

    public function daysRemaining(): int
    {
        if ($this->end_date->isPast()) return 0;
        return (int) now()->diffInDays($this->end_date, false);
    }

    public function progressPercent(): float
    {
        $total = $this->start_date->diffInDays($this->end_date);
        if ($total <= 0) return 100;
        $elapsed = $this->start_date->diffInDays(now());
        return min(100, round(($elapsed / $total) * 100, 1));
    }

    /**
     * Check if user has PT sessions left
     */
    public function canBookPT(): bool
    {
        return $this->isActive() && $this->pt_sessions_left > 0;
    }

    /**
     * Deduct one PT session
     */
    public function deductPTSession(): bool
    {
        if ($this->canBookPT()) {
            $this->decrement('pt_sessions_left');
            return true;
        }
        return false;
    }
}
