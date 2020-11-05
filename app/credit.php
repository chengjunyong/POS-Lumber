<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class credit extends Model
{
    protected $table = 'credit_note';
    protected $fillable = [
      'credit_note_code',
      'year',
      'index',
      'do_number',
      'company_id',
      'pieces',
      'tonnage',
      'total_cost',
      'amount',
      'credit_note_date',
    ];
}
