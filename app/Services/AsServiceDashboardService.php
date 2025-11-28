<?php

namespace App\Services;

use App\Models\WorkOrderModel;
use Carbon\Carbon;

class AsServiceDashboardService
{
    /**
     * Get all dashboard statistics for AsService role
     */
    public function getDashboardStats()
    {
        return [
            'metrics' => $this->getMetrics(),
            'recentWorkOrders' => $this->getRecentWorkOrders(),
            'statusBreakdown' => $this->getStatusBreakdown(),
            'priorityItems' => $this->getPriorityItems(),
        ];
    }

    /**
     * Get metrics specific to AsService
     */
    private function getMetrics()
    {
        // Total work orders created (AsService creates all work orders initially)
        $totalCreated = WorkOrderModel::count();
        
        // Work orders in validation status (awaiting AsService review)
        $totalValidating = WorkOrderModel::where('status', 'validate')->count();
        
        // Work orders queued and ready
        $totalQueue = WorkOrderModel::where('status', 'queue')->count();
        
        // Work orders completed (AsService monitors completion)
        $totalFinish = WorkOrderModel::where('status', 'finish')->count();

        return [
            'total_created' => $totalCreated,
            'total_validating' => $totalValidating,
            'total_queue' => $totalQueue,
            'total_finish' => $totalFinish,
        ];
    }

    /**
     * Get recent work orders (latest created/updated)
     */
    private function getRecentWorkOrders()
    {
        return WorkOrderModel::with(['customer', 'workType', 'salesUser'])
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->status_display = $this->getStatusDisplay($item->status);
                $item->time_ago = Carbon::parse($item->getAttributes()['updated_at'])->diffForHumans();
                return $item;
            });
    }

    /**
     * Get status breakdown counts
     */
    private function getStatusBreakdown()
    {
        $statuses = ['validate', 'queue', 'pending', 'progress', 'revision', 'migration', 'finish'];
        
        return collect($statuses)->map(function ($status) {
            $count = WorkOrderModel::where('status', $status)->count();
            return [
                'status' => $status,
                'count' => $count,
                'label' => $this->getStatusLabel($status),
            ];
        });
    }

    /**
     * Get priority items (work orders needing attention)
     */
    private function getPriorityItems()
    {
        return WorkOrderModel::where(function ($query) {
            $query->where('status', 'validate') // Awaiting validation
                ->orWhere('status', 'revision') // In revision
                ->orWhere(function ($subQuery) {
                    // Pending for more than 5 days
                    $subQuery->where('status', 'pending')
                        ->where('date_queue', '<=', Carbon::now()->subDays(5));
                });
        })
        ->with(['customer', 'workType', 'productionUser', 'salesUser'])
        ->orderByDesc('updated_at')
        ->limit(8)
        ->get()
        ->map(function ($item) {
            $item->priority_reason = $this->getPriorityReason($item);
            return $item;
        });
    }

    /**
     * Helper: Get status display text
     */
    private function getStatusDisplay($status)
    {
        $displays = [
            'validate' => 'Validasi',
            'queue' => 'Antrian',
            'pending' => 'Tertunda',
            'progress' => 'Dikerjakan',
            'revision' => 'Revisi',
            'migration' => 'Migrasi',
            'finish' => 'Selesai',
        ];

        return $displays[$status] ?? $status;
    }

    /**
     * Helper: Get status label
     */
    private function getStatusLabel($status)
    {
        return $this->getStatusDisplay($status);
    }

    /**
     * Helper: Get priority reason
     */
    private function getPriorityReason($workOrder)
    {
        if ($workOrder->status === 'validate') {
            return 'Menunggu Validasi';
        }
        
        if ($workOrder->status === 'revision') {
            return 'Dalam Revisi';
        }

        if ($workOrder->status === 'pending') {
            return 'Tertunda > 5 hari';
        }

        return 'Regular';
    }

    
}
