<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectVideo extends Model
{
    protected $table="projectvideos";

    protected $fillable = [
        'project_id',
        'video',
        'title',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
