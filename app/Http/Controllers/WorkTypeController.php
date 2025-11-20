<?php

namespace App\Http\Controllers;

use App\Models\WorkTypeModel;

class WorkTypeController extends Controller
{
    public function index()
    {
        $data = WorkTypeModel::with(['division', 'workOrders'])->get();

        return view('work-types.index', compact('data'));
    }
}
    