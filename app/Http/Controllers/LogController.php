<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LogController extends Controller
{
    /**
     * Display activity logs with filtering
     */
    public function index(Request $request)
    {
        $query = ActivityLog::query()->latest();

        // Filter by activity type
        if ($request->filled('activity_type')) {
            $query->byActivityType($request->activity_type);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->byModelType($request->model_type);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->byUser($request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $dateFrom = Carbon::createFromFormat('Y-m-d', $request->date_from)->startOfDay();
            $dateTo = Carbon::createFromFormat('Y-m-d', $request->date_to)->endOfDay();
            $query->byDateRange($dateFrom, $dateTo);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(50);
        $users = User::all();
        
        $activityTypes = [
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            'restored' => 'Restored',
            'login' => 'Login',
            'logout' => 'Logout',
            'status_changed' => 'Status Changed',
        ];

        $modelTypes = [
            'WorkOrderModel' => 'Work Order',
            'CustomerModel' => 'Customer',
            'UserModel' => 'User',
            'DivisionModel' => 'Division',
            'WorkTypeModel' => 'Work Type',
            'AccessCredentialModel' => 'Access Credential',
            'IndexingTypeModel' => 'Indexing Type',
        ];

        return view('admin.logs.index', compact('logs', 'users', 'activityTypes', 'modelTypes'));
    }

    /**
     * Display a specific log entry
     */
    public function show(ActivityLog $log)
    {
        return view('admin.logs.show', compact('log'));
    }

    /**
     * Export logs as CSV
     */
    public function export(Request $request)
    {
        $query = ActivityLog::query()->latest();

        if ($request->filled('activity_type')) {
            $query->byActivityType($request->activity_type);
        }

        if ($request->filled('model_type')) {
            $query->byModelType($request->model_type);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $dateFrom = Carbon::createFromFormat('Y-m-d', $request->date_from)->startOfDay();
            $dateTo = Carbon::createFromFormat('Y-m-d', $request->date_to)->endOfDay();
            $query->byDateRange($dateFrom, $dateTo);
        }

        $logs = $query->get();

        $filename = 'activity-logs-' . date('Y-m-d-H-i-s') . '.csv';
        $handle = fopen('php://memory', 'r+');

        // Write header
        fputcsv($handle, ['Date', 'User', 'Activity', 'Model', 'Model ID', 'Description', 'IP Address']);

        // Write data
        foreach ($logs as $log) {
            fputcsv($handle, [
                $log->created_at,
                $log->user ? $log->user->name : 'System',
                $log->getActivityTypeLabel(),
                $log->getModelTypeLabel(),
                $log->model_id,
                $log->description,
                $log->ip_address,
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
