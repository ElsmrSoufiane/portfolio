<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['fromId', 'toId', 'content','seen'])]
class Message extends Model
{
          
}
