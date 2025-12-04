<?php

namespace App\Http\Controllers;

use App\Models\IndexingTypeModel;
use Illuminate\Http\Request;

class IndexingTypeController extends Controller
{
    public function index()
    {
        $data = IndexingTypeModel::get();
        return view('indexing-types.index', compact('data'));
    }

    public function create()
    {
        return view('indexing-types.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'indexing_name' => 'required|string|max:255|unique:table_indexing_types,indexing_name',
            'description' => 'nullable|string'
        ]);

        IndexingTypeModel::create($validated);

        return redirect()->route('admin.indexing-types.index')
            ->with('success', 'Indexing Type berhasil ditambahkan.');
    }

    public function show(IndexingTypeModel $indexingType)
    {
        return view('admin.indexing-types.show', compact('indexingType'));
    }

    public function edit(IndexingTypeModel $indexingType)
    {
        return view('indexing-types.form', compact('indexingType'));
    }

    public function update(Request $request, IndexingTypeModel $indexingType)
    {
        $validated = $request->validate([
            'indexing_name' => 'required|string|max:255|unique:table_indexing_types,indexing_name,' . $indexingType->id,
            'description' => 'nullable|string'
        ]);

        $indexingType->update($validated);

        return redirect()->route('admin.indexing-types.index')
            ->with('success', 'Indexing Type berhasil diperbarui.');
    }

    public function destroy(IndexingTypeModel $indexingType)
    {
        $indexingType->delete();

        return redirect()->route('admin.indexing-types.index')
            ->with('success', 'Indexing Type berhasil dihapus.');
    }
}