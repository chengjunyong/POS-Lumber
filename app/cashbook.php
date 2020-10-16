<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cashbook extends Model
{
    protected $table = 'cashbook';
    protected $fillable = [
      'company_id',
      'company_name',
      'type',
      'amount',
    ];
}
