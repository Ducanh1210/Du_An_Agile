<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'item_type',
        'item_id',
        'reason',
        'status',
        'admin_note',
        'resolved_by'
    ];

    /**
     * Get the parent item model (Booking or Schedule).
     */
    public function item()
    {
        return $this->morphTo();
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
