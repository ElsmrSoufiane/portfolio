<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSection extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'content',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
