<?php

namespace App\Models;
use App\Models\Image_projet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'image',
        'description',
        'code_source',
        'deploiement'
    ];
    protected $table = 'projets';
    public function images()
    {
        return $this->hasMany(Image_projet::class);
    }
}