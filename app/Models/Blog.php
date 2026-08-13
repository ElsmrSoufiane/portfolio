<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'duration',
        'views',
        'video',
        'image',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
