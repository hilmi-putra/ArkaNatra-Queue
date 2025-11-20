<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;

class CustomerController extends Controller
{
    public function index()
    {
        $data = CustomerModel::with(['workOrders', 'accessCredentials'])->get();

        return view('customers.index', compact('data'));
    }
}
