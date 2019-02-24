<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model {

    protected $guarded = array('id');

    public static $rules = array(
        'user_id' => 'required',
        'content' => 'size:65535'
    );

    public function user() {
        return $this->belongsTo(User::class);
    }
}
