<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{

    /**
     * fillableカラム
     */
    protected $fillable = ['id', 'name'];

    protected $table = 'staffs';

    /**
     * 映画テーブルとのリレーション情報
     *
     * @return Movie
     */
    public function movies()
    {
        return $this->belongsToMany(
            'App\Models\Movie',
            'movie_staff_rels',
            'staff_id',
            'movie_id'
        )->withTimestamps();
    }
}
