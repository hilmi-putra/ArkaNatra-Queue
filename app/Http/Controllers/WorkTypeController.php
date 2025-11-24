<?php

namespace App\Http\Controllers;

use App\Models\WorkTypeModel;
use App\Models\DivisionModel;
use Illuminate\Http\Request;

class WorkTypeController extends Controller
{
    public function index()
    {
        $data = WorkTypeModel::with('division')->get();
        return view('work-types.index', compact('data'));
    }

    public function create()
    {
        $divisions = DivisionModel::all();
        return view('work-types.form', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_type' => 'required|string|max:255',
            'regular_estimation_days' => 'required|integer|min:1',
            'extra_days_per_quantity' => 'required|integer|min:0',
            'fast_track_estimation_days' => 'required|integer|min:1',
            'division_id' => 'required|exists:table_division,id'
        ]);

        WorkTypeModel::create($validated);

        return redirect()->route('admin.work-types.index')
            ->with('success', 'Work Type berhasil ditambahkan.');
    }

    public function show(WorkTypeModel $workType)
    {
        $workType->load('division');
        return view('admin.work-types.show', compact('workType'));
    }

    public function edit(WorkTypeModel $workType)
    {
        $divisions = DivisionModel::all();
        return view('work-types.form', compact('workType', 'divisions'));
    }

    public function update(Request $request, WorkTypeModel $workType)
    {
        $validated = $request->validate([
            'work_type' => 'required|string|max:255',
            'regular_estimation_days' => 'required|integer|min:1',
            'extra_days_per_quantity' => 'required|integer|min:0',
            'fast_track_estimation_days' => 'required|integer|min:1',
            'division_id' => 'required|exists:table_division,id'
        ]);

        $workType->update($validated);

        return redirect()->route('admin.work-types.index')
            ->with('success', 'Work Type berhasil diperbarui.');
    }

    public function destroy(WorkTypeModel $workType)
    {
        $workType->delete();

        return redirect()->route('admin.work-types.index')
            ->with('success', 'Work Type berhasil dihapus.');
    }
}