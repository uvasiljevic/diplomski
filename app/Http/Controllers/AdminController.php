<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request){
        return view('/uv-admin/components/dashboard/dashboard', $this->data);

    }

    public function order(Request $request){
        $filter   = $this->filter();

        if($request->has('o_status') && $request->o_status != 0){
            $filter['status'] = "= ".$request->o_status;
        }
        if($request->has('o_del') && $request->o_del != 0){
            $filter['del'] = "= ".$request->o_del;
        }
        if($request->has('o_sent') && $request->o_sent != 0){
            $filter['sent'] = "= ".$request->o_sent;
        }
        if($request->has('o_dateFrom') && $request->o_dateFrom != null){
            $filter['dateCreate'] = "> ".$request->o_dateFrom;
        }
        if($request->has('o_dateTo') && $request->o_dateTo != null){
            $filter['dateCreate'] = "< ".$request->o_dateTo;
        }
        if($request->has('o_orderId') && $request->o_orderId != null){
            $filter['id'] = "= ".$request->o_orderId;
        }

        $records  = $this->modelOrder->getRecords($this->modelOrder->getTableName(), $filter);
        $this->data['records']           = $records;
        $this->data['statusFilterArray'] = $this->statusFilterArray();
        $this->data['deleteFilterArray'] = $this->deleteFilterArray();
        $this->data['yesNoArray']        = $this->yesNoArray();

        if($request->ajax()){
            return response()->json($records,  200);
        }

        return view('/uv-admin/components/order/order', $this->data);

    }
}
