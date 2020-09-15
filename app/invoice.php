<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    protected $table = 'invoice';
    protected $fillable = [
      'company_id',
      'invoice_id',
      'pieces',
      'tonnage',
      'price',
      'amount',
    ];
}
