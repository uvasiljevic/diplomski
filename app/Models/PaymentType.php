<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends ModelUV
{
    use HasFactory;

    protected $table     = 'uv_payment_type';
    protected $tableName = 'payment_type';
}
