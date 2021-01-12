<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends ModelUV
{
    use HasFactory;

    protected $table     = 'uv_courier';
    protected $tableName = 'courier';

    public function countCourierPrice($courier, $totalCartPrice){
        $courierPrice = $courier->price;
        if($totalCartPrice > 100){
            $courierPrice = 0;
        }

        return $courierPrice;
    }
}
