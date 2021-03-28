<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request){
        return view('/uv-admin/components/dashboard/dashboard', $this->data);

    }

    public function order(Request $request){
        $records  = $this->modelOrder->getRecords($this->modelOrder->getTableName());
        $this->data['records']           = $records;
        $this->data['statusFilterArray'] = $this->statusFilterArray();
        $this->data['deleteFilterArray'] = $this->deleteFilterArray();
        $this->data['yesNoArray']        = $this->yesNoArray();

        return view('/uv-admin/components/order/order', $this->data);

    }
}
