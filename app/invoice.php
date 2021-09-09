<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoice extends Model
{
    use SoftDeletes;
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
