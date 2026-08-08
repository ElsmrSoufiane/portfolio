<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
protected $fillable = [
    'title'
];

public function themes(){
    return $this->hasMany(Theme::class);
}
}
