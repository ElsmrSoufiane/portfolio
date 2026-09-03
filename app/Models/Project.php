<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kirschbaum\Commentions\HasComments;
use Kirschbaum\Commentions\Contracts\Commentable;

class Project extends Model implements Commentable
{
    use HasComments;

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
