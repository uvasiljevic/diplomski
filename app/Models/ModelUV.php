<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelUV extends Model
{
    use HasFactory;

    protected $prefix = 'uv_';

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getTableName()
    {
        return $this->getPrefix().$this->tableName;
    }

    public function getRecords($table, $filter = array(), $offset = 0, $limit = 10, $sort = 'DESC'){

        $sql   = \DB::table($table);

        $sql   = $sql->orderBy($table.'.id', $sort);

        if(count($filter)){
            foreach ($filter as $column => $value){
                $explode  = explode(' ', $value);
                $operator = $explode[0];
                $value    = $explode[1];

                $sql = $sql->where($table.'.'.$column, $operator, $value);
            }
        }

        $sql = $sql->offset($offset)->limit($limit)->get();

        return $sql;

    }

    public function getRecord($table, $filter = array()){

        $sql   = \DB::table($table);

        if(count($filter)){
            foreach ($filter as $column => $value){
                $explode  = explode(' ', $value);
                $operator = $explode[0];
                $value    = $explode[1];

                $sql = $sql->where($table.'.'.$column, $operator, $value);
            }
        }

        $sql = $sql->get();

        return $sql;

    }
}
