<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends ModelUV
{
    use HasFactory;

    protected $table     = 'uv_order';
    protected $tableName = 'order';

    public $timestamps   = false;
}
