<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Themeimage extends Model
{
         protected $fillable = [
            'theme_id',
            'image',
         ];

         public function theme(){
            return $this->belongsTo(Theme::class);
         }
}
