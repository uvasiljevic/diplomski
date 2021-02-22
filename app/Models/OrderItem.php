<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends ModelUV
{
    use HasFactory;

    protected $table     = 'uv_order_item';
    protected $tableName = 'order_item';

    public $timestamps   = false;
}
