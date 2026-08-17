<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'title',
        'project_id',
        'code',
        'description',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function themeimages()
    {
        return $this->hasMany(Themeimage::class);
    }
}
