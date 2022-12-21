<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class company extends Model
{
    use SoftDeletes;

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
