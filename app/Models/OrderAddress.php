<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends ModelUV
{
    use HasFactory;

    protected $table     = 'uv_order_address';
    protected $tableName = 'order_address';

    public $timestamps   = false;
}
