<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
      protected $fillable = [
        "title",
        "content",
        "blog_id",
      ];

      public function blog(){
        return $this->belongsTo(Blog::class);
      }
}
