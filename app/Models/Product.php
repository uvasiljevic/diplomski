<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends ModelUV
{
    use HasFactory;

    protected $table     = 'uv_product';
    protected $tableName = 'product';

    public $timestamps   = false;

    public function getRecords($table, $filter = array(), $offset = 0, $limit = 10, $sort = 'id.DESC', $search = '')
    {
        $sort = explode('.', $sort);

        $sql   = \DB::table($table)
            ->select($table.'.id', $table.'.permalink', $table.'.name as title',  $table.'.description', $table.'.image', $table.'.quantity', $table.'.price', $table.'.actionId', $this->getPrefix().'action.name', $this->getPrefix().'action.class', $this->getPrefix().'category.permalink as categoryPermalink', $this->getPrefix().'category.name as categoryName')
            ->join($this->getPrefix().'action',$this->getPrefix().'action.id','=',$table.'.actionId')
            ->join($this->getPrefix().'category',$this->getPrefix().'category.id','=',$table.'.categoryId');

        $sql   = $sql->orderBy($table.'.'.$sort[0], $sort[1]);

        if(count($filter)){
            foreach ($filter as $column => $value){
                $explode  = explode(' ', $value);
                $operator = $explode[0];
                $value    = $explode[1];

                $columnArray = explode('.', $column);
                if(count($columnArray) > 1){
                    $sql = $sql->where($this->getPrefix().$column, $operator, $value);
                }else{
                    $sql = $sql->where($table.'.'.$column, $operator, $value);
                }
            }
        }

        if($search != ''){
            $sql = $sql->where($table.'.name', 'LIKE', '%'.$search.'%');
        }

        $sql = $sql->offset($offset)->limit($limit)->paginate(10);

        return $sql;
    }


    public function getRecordsPublic($table, $filter = array(), $offset = 0, $limit = 10, $sort = 'id.DESC', $search = '')
    {
        $sort = explode('.', $sort);

        $sql   = \DB::table($table)
            ->select($table.'.permalink', $table.'.name as title',  $table.'.description', $table.'.image', $table.'.price', $table.'.actionId', $this->getPrefix().'action.name', $this->getPrefix().'action.class', $this->getPrefix().'category.permalink as categoryPermalink')
            ->join($this->getPrefix().'action',$this->getPrefix().'action.id','=',$table.'.actionId')
            ->join($this->getPrefix().'category',$this->getPrefix().'category.id','=',$table.'.categoryId');

        $sql   = $sql->orderBy($table.'.'.$sort[0], $sort[1]);

        if(count($filter)){
            foreach ($filter as $column => $value){
                $explode  = explode(' ', $value);
                $operator = $explode[0];
                $value    = $explode[1];

                $columnArray = explode('.', $column);
                if(count($columnArray) > 1){
                    $sql = $sql->where($this->getPrefix().$column, $operator, $value);
                }else{
                    $sql = $sql->where($table.'.'.$column, $operator, $value);
                }
            }
        }

        if($search != ''){
            $sql = $sql->where($table.'.name', 'LIKE', '%'.$search.'%');
        }

        $sql = $sql->offset($offset)->limit($limit)->get();

        return $sql;
    }

    public function getRecordPublic($table, $filter = array())
    {
        $sql   = \DB::table($table)
            ->select($table.'.id', $table.'.name as title', $table.'.oldPrice', $table.'.description', $table.'.shortDescription', $table.'.image', $table.'.price', $table.'.quantity', $table.'.actionId', $this->getPrefix().'action.name', $this->getPrefix().'action.class', $this->getPrefix().'category.permalink as categoryPermalink')
            ->join($this->getPrefix().'action',$this->getPrefix().'action.id','=',$table.'.actionId')
            ->join($this->getPrefix().'category',$this->getPrefix().'category.id','=',$table.'.categoryId');

        if(count($filter)){
            foreach ($filter as $column => $value){
                $explode  = explode(' ', $value);
                $operator = $explode[0];
                $value    = $explode[1];

                $columnArray = explode('.', $column);
                if(count($columnArray) > 1){
                    $sql = $sql->where($this->getPrefix().$column, $operator, $value);
                }else{
                    $sql = $sql->where($table.'.'.$column, $operator, $value);
                }
            }
        }

        $sql = $sql->get();

        return $sql;
    }

    public function breadCrumbs($product){
        $permalink = '/';

        $category  = Category::where('id', $product->categoryId)->first();

        $permalink .= $category->permalink.'/'.$product->permalink;

        return $permalink;

    }
}
