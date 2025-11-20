<?php

namespace App\Http\Controllers;

use App\Models\WorkOrderIndexingModel;

class WorkOrderIndexingController extends Controller
{
    public function index()
    {
        $data = WorkOrderIndexingModel::with(['workOrder', 'indexingType'])->get();

        return view('work-order-indexings.index', compact('data'));
    }
}
