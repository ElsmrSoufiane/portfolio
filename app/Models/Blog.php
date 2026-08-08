<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
protected $fillable=[
    "title",
    "video",
];

public function sections(){
    return $this->hasMany(Section::class);
}
}
