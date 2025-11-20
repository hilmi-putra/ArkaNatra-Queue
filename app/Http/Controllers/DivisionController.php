<?php

namespace App\Http\Controllers;

use App\Models\DivisionModel;

class DivisionController extends Controller
{
    public function index()
    {
        $data = DivisionModel::with(['users', 'workTypes', 'workOrders'])->get();

        return view('divisions.index', compact('data'));
    }
}
