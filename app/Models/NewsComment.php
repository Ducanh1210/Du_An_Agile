<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $news_id
 * @property int $user_id
 * @property string $content
 * @property bool $is_approved
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */
class NewsComment extends Model
{
    use HasFactory;

    protected $fillable = ['news_id', 'user_id', 'content', 'is_approved'];

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
