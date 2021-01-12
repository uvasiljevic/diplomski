<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends ModelUV
{
    use HasFactory;

    protected $tableName = 'menu';

    public function getMenu(){
        $categories = new Category();

        $menus = \DB::table($this->getTableName())
            ->get();

        foreach($menus as $menu){

            $menu->categories = $categories->getCategoriesForMenu($menu->id);

        }

        return $menus;
    }
}
