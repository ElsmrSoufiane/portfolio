<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kirschbaum\Commentions\HasComments;
use Kirschbaum\Commentions\Contracts\Commentable;

class Blog extends Model implements Commentable 
{
    use HasComments;
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
