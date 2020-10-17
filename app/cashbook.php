<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cashbook extends Model
{
    protected $table = 'cashbook';
    protected $fillable = [
      'company_id',
      'company_name',
      'invoice_id',
      'invoice_code',
      'invoice_date',
      'type',
      'amount',
    ];
}
