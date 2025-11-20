<?php

namespace App\Http\Controllers;

use App\Models\WorkOrderModel;

class WorkOrderController extends Controller
{
    public function index()
    {
        $data = WorkOrderModel::with(['customer', 'user', 'division', 'workType', 'indexing'])->get();

        return view('work-orders.index', compact('data'));
    }
}
