<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBox extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'box_id'
    ];
}
