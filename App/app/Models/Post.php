<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Movie;
use DateTime;

class Post extends Model
{
    /**
     * fillableカラム
     */
    protected $fillable = ['content', 'created_at'];

    /**
     * guardedカラム
     */
    protected $guarded = ['id'];

    /**
     * 追加カラム：投稿経過時間
     */
    protected $appends = ['post_at'];

    public function getPostAtAttribute()
    {
        $now = new DateTime();
        $interval = $now->diff($this->created_at);
        if($interval->y !== 0) {
            return $this->created_at->format('Y年n月j日');
        } elseif($interval->m !== 0 || $interval->d !== 0) {
            return $this->created_at->format('n月j日');
        } elseif($interval->h !== 0) {
            return $interval->h.'時間前';
        } elseif ($interval->i !== 0) {
            return $interval->i.'分前';
        } elseif ($interval->s !== 0) {
            return $interval->s.'秒前';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
