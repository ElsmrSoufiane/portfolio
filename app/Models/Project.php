<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function themes()
    {
        return $this->hasMany(Theme::class);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function sections()
    {
        return $this->hasMany(ProjectSection::class);
    }

    public function videos()
    {
        return $this->hasMany(ProjectVideo::class);
    }
}
