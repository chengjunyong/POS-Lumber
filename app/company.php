<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    protected $table = 'company';
    protected $fillable = [
      'company_name',
      'address',
      'contact',
      'city',
      'postcode',
      'state',
      'active',
    ];
}
