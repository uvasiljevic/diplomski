<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends ModelUV
{

    use HasFactory;

    protected $table     = 'uv_category';
    protected $tableName = 'category';

    public function getCategoriesForMenu($parentId){

        return \DB::table($this->getTableName())
            ->where('parentId', $parentId)
            ->where('del', -1)
            ->where('status', 1)
            ->get();

    }
}
