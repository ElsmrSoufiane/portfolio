<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $table="projectimages";
    
    protected $fillable = [
        'project_id',
        'image',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
