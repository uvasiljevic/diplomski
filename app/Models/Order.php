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

    public function getRecords($table, $filter = array(), $offset = 0, $limit = 10, $sort = 'id.DESC', $search = '')
    {
        $sort = explode('.', $sort);

        $sql   = \DB::table($table)
            ->select($table.'.*', $this->getPrefix().'order_address.email', $this->getPrefix().'order_address.phone', $this->getPrefix().'order_address.city', $this->getPrefix().'order_address.zipCode', $this->getPrefix().'order_address.street', $this->getPrefix().'order_address.streetNumber' )
            ->join($this->getPrefix().'order_address',$this->getPrefix().'order_address.orderId','=',$table.'.id');

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
}
