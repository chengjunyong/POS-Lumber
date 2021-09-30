<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cashbook extends Model
{
    use SoftDeletes;
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
