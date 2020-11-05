<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class credit_detail extends Model
{
    protected $table = 'credit_note_detail';
    protected $fillable = [
      'product_id',
      'product_name',
      'credit_note_id',
      'sub',
      'variation_id',
      'variation_display',
      'piece_col',
      'total_piece',
      'price',
      'cost',
      'amount',
      'tonnage',
      'footrun',
      'cal_type',
    ];
}
