<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'user_id',
        'title',
        'content',
        'status',
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
