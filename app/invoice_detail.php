<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoice_detail extends Model
{
    use SoftDeletes;
    protected $table = 'invoice_detail';
    protected $fillable = [
      'product_id',
      'product_name',
      'invoice_id',
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
