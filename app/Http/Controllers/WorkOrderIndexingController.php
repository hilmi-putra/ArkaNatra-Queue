<?php

namespace App\Http\Controllers;

use App\Models\WorkOrderIndexingModel;
use App\Models\WorkOrderModel;
use App\Models\IndexingTypeModel;
use Illuminate\Http\Request;

class WorkOrderIndexingController extends Controller
{
    public function index()
    {
        $data = WorkOrderIndexingModel::with(['workOrder', 'indexingType'])->get();
        return view('work-order-indexings.index', compact('data'));
    }

    public function create()
    {
        $workOrders = WorkOrderModel::orderBy('id', 'desc')->get();
        $indexingTypes = IndexingTypeModel::all();

        return view('work-order-indexings.form', compact('workOrders', 'indexingTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'work_order_id' => 'required|exists:table_work_orders,id',
            'indexing_type_id' => 'required|exists:table_indexing_types,id',
            'finished' => 'nullable|boolean'
        ]);

        WorkOrderIndexingModel::create([
            'work_order_id' => $request->work_order_id,
            'indexing_type_id' => $request->indexing_type_id,
            'finished' => $request->has('finished') ? 1 : 0,
        ]);

        return redirect()->route('asservice.work-order-indexing.index')
            ->with('success', 'Work Order Indexing berhasil dibuat.');
    }

    public function edit(WorkOrderIndexingModel $work_order_indexing)
    {
        $workOrderIndexing = $work_order_indexing;
        $workOrders = WorkOrderModel::orderBy('id', 'desc')->get();
        $indexingTypes = IndexingTypeModel::all();

        return view('work-order-indexings.form', compact('workOrderIndexing', 'workOrders', 'indexingTypes'));
    }

    public function show(WorkOrderIndexingModel $work_order_indexing)
    {
        // Redirect to edit for now to keep behavior consistent
        return redirect()->route('asservice.work-order-indexing.edit', $work_order_indexing->id);
    }

    public function update(Request $request, WorkOrderIndexingModel $work_order_indexing)
    {
        $request->validate([
            'work_order_id' => 'required|exists:table_work_orders,id',
            'indexing_type_id' => 'required|exists:table_indexing_types,id',
            'finished' => 'nullable|boolean'
        ]);

        $work_order_indexing->update([
            'work_order_id' => $request->work_order_id,
            'indexing_type_id' => $request->indexing_type_id,
            'finished' => $request->has('finished') ? 1 : 0,
        ]);

        return redirect()->route('asservice.work-order-indexing.index')
            ->with('success', 'Work Order Indexing berhasil diupdate.');
    }

    public function destroy(WorkOrderIndexingModel $work_order_indexing)
    {
        $work_order_indexing->delete();
        return redirect()->route('asservice.work-order-indexing.index')
            ->with('success', 'Work Order Indexing berhasil dihapus.');
    }
}
