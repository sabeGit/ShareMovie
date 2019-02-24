<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model {

    protected $fillable = ['id', 'name'];

    protected $table = 'staffs';

    public function movies() {
        return $this->belongsToMany('App\Models\Movie', 'movie_staff_rels', 'staff_id', 'movie_id')->withTimestamps();
    }
}
