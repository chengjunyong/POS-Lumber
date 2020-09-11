<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class variation extends Model
{
    protected $table = 'variation';
    protected $fillable = [
      'first',
      'second',
    ];
}
