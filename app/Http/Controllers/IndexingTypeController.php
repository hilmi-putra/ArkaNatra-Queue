<?php

namespace App\Http\Controllers;

use App\Models\IndexingTypeModel;

class IndexingTypeController extends Controller
{
    public function index()
    {
        $data = IndexingTypeModel::with('workOrderIndexing')->get();

        return view('indexing-types.index', compact('data'));
    }
}
