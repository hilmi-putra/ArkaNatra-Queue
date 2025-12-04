<?php

namespace App\Http\Controllers;

use App\Models\DivisionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisionController extends Controller
{
    public function index()
    {
        $data = DivisionModel::with(['users', 'workTypes', 'workOrders'])->get();
        return view('divisions.index', compact('data'));
    }

    public function create()
    {
        return view('divisions.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:table_division,name'
        ]);

        try {
            DivisionModel::create($request->all());
            return redirect()->route('admin.divisions.index')
                ->with('success', 'Division created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create division: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $division = DivisionModel::with(['users', 'workTypes', 'workOrders'])
            ->findOrFail($id);
        
        return view('divisions.show', compact('division'));
    }

    public function edit($id)
    {
        $division = DivisionModel::findOrFail($id);
        return view('divisions.form', compact('division'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:table_division,name,' . $id
        ]);

        try {
            $division = DivisionModel::findOrFail($id);
            $division->update($request->all());
            
            return redirect()->route('admin.divisions.index')
                ->with('success', 'Division updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update division: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $division = DivisionModel::findOrFail($id);
            
            // Check if division has related records
            if ($division->users()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Cannot delete division because it has users assigned.');
            }
            
            if ($division->workTypes()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Cannot delete division because it has work types assigned.');
            }
            
            if ($division->workOrders()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Cannot delete division because it has work orders assigned.');
            }
            
            $division->delete();
            
            DB::commit();
            
            return redirect()->route('admin.divisions.index')
                ->with('success', 'Division deleted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Failed to delete division: ' . $e->getMessage());
        }
    }
}