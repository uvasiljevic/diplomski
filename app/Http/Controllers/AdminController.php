<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request){
//dd('ulazi');
        return view('/uv-admin/components/dashboard/dashboard', $this->data);

    }
}
