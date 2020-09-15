<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice_detail extends Model
{
    protected $table = 'invoice_detail';
    protected $fillable = [
      'product_id',
      'invoice_id',
      'sub',
      'variation_id',
      'piece_col',
      'total_piece',
      'price',
      'amount',
      'tonnage',
      'footrun',
    ];
}
