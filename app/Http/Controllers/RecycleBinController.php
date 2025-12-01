<?php

namespace App\Http\Controllers;

use App\Models\WorkOrderModel;
use App\Models\CustomerModel;
use App\Models\DivisionModel;
use App\Models\WorkTypeModel;
use App\Models\IndexingTypeModel;
use App\Models\AccessCredentialModel;
use App\Models\WorkOrderIndexingModel;
use Illuminate\Http\Request;

class RecycleBinController extends Controller
{
    /**
     * Display recycle bin items
     */
    public function index(Request $request)
    {
        $modelType = $request->query('model', 'all');
        $trashedItems = [];
        $totalItems = 0;

        $models = [
            'WorkOrderModel' => WorkOrderModel::class,
            'CustomerModel' => CustomerModel::class,
            'DivisionModel' => DivisionModel::class,
            'WorkTypeModel' => WorkTypeModel::class,
            'IndexingTypeModel' => IndexingTypeModel::class,
            'AccessCredentialModel' => AccessCredentialModel::class,
            'WorkOrderIndexingModel' => WorkOrderIndexingModel::class,
        ];

        if ($modelType !== 'all' && isset($models[$modelType])) {
            $modelClass = $models[$modelType];
            $trashedItems = $modelClass::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(50);
            $totalItems = $modelClass::onlyTrashed()->count();
        } else {
            // Get all trashed items from all models
            foreach ($models as $modelName => $modelClass) {
                $count = $modelClass::onlyTrashed()->count();
                $totalItems += $count;
                
                if ($count > 0) {
                    $trashedItems[$modelName] = [
                        'count' => $count,
                        'icon' => $this->getModelIcon($modelName),
                        'label' => $this->getModelLabel($modelName),
                    ];
                }
            }
        }

        $modelTypes = [
            'WorkOrderModel' => 'Work Order',
            'CustomerModel' => 'Customer',
            'DivisionModel' => 'Division',
            'WorkTypeModel' => 'Work Type',
            'IndexingTypeModel' => 'Indexing Type',
            'AccessCredentialModel' => 'Access Credential',
            'WorkOrderIndexingModel' => 'Work Order Indexing',
        ];

        return view('admin.recycle-bin.index', compact('trashedItems', 'totalItems', 'modelType', 'modelTypes'));
    }

    /**
     * Restore a soft-deleted item
     */
    public function restore(Request $request)
    {
        $modelType = $request->input('model_type');
        $modelId = $request->input('model_id');

        $models = [
            'WorkOrderModel' => WorkOrderModel::class,
            'CustomerModel' => CustomerModel::class,
            'DivisionModel' => DivisionModel::class,
            'WorkTypeModel' => WorkTypeModel::class,
            'IndexingTypeModel' => IndexingTypeModel::class,
            'AccessCredentialModel' => AccessCredentialModel::class,
            'WorkOrderIndexingModel' => WorkOrderIndexingModel::class,
        ];

        if (!isset($models[$modelType])) {
            return response()->json(['message' => 'Invalid model type'], 400);
        }

        $modelClass = $models[$modelType];
        $item = $modelClass::withTrashed()->find($modelId);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->restore();

        // Log the restoration
        \App\Services\ActivityLogger::logRestored($modelType, $modelId);

        return response()->json(['message' => ucfirst($this->getModelLabel($modelType)) . ' has been restored successfully.'], 200);
    }

    /**
     * Permanently delete an item
     */
    public function forceDelete(Request $request)
    {
        $modelType = $request->input('model_type');
        $modelId = $request->input('model_id');

        $models = [
            'WorkOrderModel' => WorkOrderModel::class,
            'CustomerModel' => CustomerModel::class,
            'DivisionModel' => DivisionModel::class,
            'WorkTypeModel' => WorkTypeModel::class,
            'IndexingTypeModel' => IndexingTypeModel::class,
            'AccessCredentialModel' => AccessCredentialModel::class,
            'WorkOrderIndexingModel' => WorkOrderIndexingModel::class,
        ];

        if (!isset($models[$modelType])) {
            return response()->json(['message' => 'Invalid model type'], 400);
        }

        $modelClass = $models[$modelType];
        $item = $modelClass::withTrashed()->find($modelId);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->forceDelete();

        return response()->json(['message' => ucfirst($this->getModelLabel($modelType)) . ' has been permanently deleted.'], 200);
    }

    /**
     * Empty the entire recycle bin
     */
    public function emptyBin(Request $request)
    {
        $models = [
            WorkOrderModel::class,
            CustomerModel::class,
            DivisionModel::class,
            WorkTypeModel::class,
            IndexingTypeModel::class,
            AccessCredentialModel::class,
            WorkOrderIndexingModel::class,
        ];

        foreach ($models as $modelClass) {
            $modelClass::onlyTrashed()->forceDelete();
        }

        return response()->json(['message' => 'Recycle bin has been emptied.'], 200);
    }

    /**
     * Get model icon based on type
     */
    private function getModelIcon($modelType)
    {
        $icons = [
            'WorkOrderModel' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><path d="M14 2v6h6" /><path d="M16 13H8" /><path d="M16 17H8" /><path d="M10 9H8" />',
            'CustomerModel' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" />',
            'DivisionModel' => '<rect x="3" y="3" width="7" height="7" /><rect x="14" y="3" width="7" height="7" /><rect x="14" y="14" width="7" height="7" /><rect x="3" y="14" width="7" height="7" />',
            'WorkTypeModel' => '<path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4" /><polyline points="17 9 12 4 7 9" /><line x1="12" x2="12" y1="4" y2="20" />',
            'IndexingTypeModel' => '<path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />',
            'AccessCredentialModel' => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2" /><path d="M7 11V7a5 5 0 0 1 10 0v4" />',
            'WorkOrderIndexingModel' => '<path d="M19.8 17.6a2.14 2.14 0 0 0 1.25-1.9v-11.4a2.14 2.14 0 0 0-1.25-1.9L12 1 4.2 3.6a2.14 2.14 0 0 0-1.25 1.9v11.4a2.14 2.14 0 0 0 1.25 1.9l7.8 2.6z" /><path d="m9 9 3 2 3-2" /><path d="m9 15 3 2 3-2" />',
        ];

        return $icons[$modelType] ?? '';
    }

    /**
     * Get model label
     */
    private function getModelLabel($modelType)
    {
        $labels = [
            'WorkOrderModel' => 'Work Order',
            'CustomerModel' => 'Customer',
            'DivisionModel' => 'Division',
            'WorkTypeModel' => 'Work Type',
            'IndexingTypeModel' => 'Indexing Type',
            'AccessCredentialModel' => 'Access Credential',
            'WorkOrderIndexingModel' => 'Work Order Indexing',
        ];

        return $labels[$modelType] ?? $modelType;
    }
}
