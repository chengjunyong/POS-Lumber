<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    protected $table = 'invoice';
    protected $fillable = [
      'invoice_code',
      'year',
      'index',
      'do_number',
      'company_id',
      'pieces',
      'tonnage',
      'total_cost',
      'amount',
      'invoice_date',
    ];
}
