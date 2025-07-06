<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
class Image_projet extends Model
{
    use HasFactory;
   protected $fillable = [
        'titre',
        'image',
        'description','project_id'
        
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
