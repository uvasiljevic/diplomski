<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends ModelUV
{
    use HasFactory;

    protected $tableName = 'baner';

    public function getSmallAd(){

        return \DB::table($this->getTableName())
            ->where('isLarge',-1)
            ->get();

    }
    public function getLargeAd(){

        return \DB::table($this->getTableName())
            ->where('isLarge',1)
            ->get();

    }


}
