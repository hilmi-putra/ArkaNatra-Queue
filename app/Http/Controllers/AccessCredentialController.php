<?php

namespace App\Http\Controllers;

use App\Models\AccessCredentialModel;

class AccessCredentialController extends Controller
{
    public function index()
    {
        $data = AccessCredentialModel::with('customer')->get();

        return view('access-credentials.index', compact('data'));
    }
}
