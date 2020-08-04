<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = [
        'name',
        'max_volume',
        'current_volume',
        'fruit_id'
    ];

    public static function rules()
    {
        return [
            'name' => 'required|string',
            'max_volume' => 'required|numeric|min:1',
            'fruit_id' => 'required|numeric|min:1',
        ];
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_boxes', 'box_id');
    }

    public function fruit(){
        return $this->hasOne(Fruit::class, 'id', 'fruit_id');
    }

}
