<?php

namespace App\Services;

use App\Models\WorkOrderModel;
use Carbon\Carbon;
use Exception;

class ProductionDashboardService
{
    /**
     * Get all dashboard statistics for Production role
     */
    public function getDashboardStats($userId)
    {
        return [
            'metrics' => $this->getMetrics($userId),
            'queueInfo' => $this->getQueueInfo($userId),
            'recentWorkOrders' => $this->getRecentWorkOrders($userId),
            'statusBreakdown' => $this->getStatusBreakdown($userId),
            'performanceMetrics' => $this->getPerformanceMetrics($userId),
        ];
    }

    /**
     * Get metrics specific to Production user
     */
    private function getMetrics($userId)
    {
        // Total work orders assigned to this production user
        $totalAssigned = WorkOrderModel::where('production_id', $userId)->count();
        
        // In progress work orders
        $totalProgress = WorkOrderModel::where('production_id', $userId)
            ->where('status', 'progress')
            ->count();
        
        // Completed work orders
        $totalFinish = WorkOrderModel::where('production_id', $userId)
            ->where('status', 'finish')
            ->count();
        
        // In queue work orders
        $totalQueue = WorkOrderModel::where('production_id', $userId)
            ->where('status', 'queue')
            ->count();

        return [
            'total_assigned' => $totalAssigned,
            'total_progress' => $totalProgress,
            'total_finish' => $totalFinish,
            'total_queue' => $totalQueue,
        ];
    }

    /**
     * Get queue information
     */
    private function getQueueInfo($userId)
    {
        $queueItems = WorkOrderModel::where('production_id', $userId)
            ->where('status', 'queue')
            ->with(['customer', 'workType', 'salesUser'])
            ->orderBy('antrian_ke', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $item->time_ago = $this->getSafeTimeAgo($item->getAttributes()['updated_at']);
                
                // Ensure we have the required properties for the view
                $item->customer_name = $item->customer->name ?? 'N/A';
                $item->work_type = $item->workType->name ?? 'N/A';
                $item->antrian_ke = $item->antrian_ke ?? 0;
                
                return $item;
            });

        return [
            'total_in_queue' => WorkOrderModel::where('production_id', $userId)
                ->where('status', 'queue')
                ->count(),
            'items' => $queueItems,
        ];
    }

    /**
     * Get recent work orders for this production user
     */
    private function getRecentWorkOrders($userId)
    {
        return WorkOrderModel::where('production_id', $userId)
            ->with(['customer', 'workType', 'salesUser'])
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->status_display = $this->getStatusDisplay($item->status);
                $item->time_ago = $this->getSafeTimeAgo($item->getAttributes()['updated_at']);
                return $item;
            });
    }

    /**
     * Get status breakdown for this production user
     */
    private function getStatusBreakdown($userId)
    {
        $statuses = ['queue', 'progress', 'revision', 'migration', 'finish'];
        
        return collect($statuses)->map(function ($status) use ($userId) {
            $count = WorkOrderModel::where('production_id', $userId)
                ->where('status', $status)
                ->count();
            
            return [
                'status' => $status,
                'count' => $count,
                'label' => $this->getStatusLabel($status),
            ];
        });
    }

    /**
     * Get performance metrics
     */
    private function getPerformanceMetrics($userId)
    {
        $total = WorkOrderModel::where('production_id', $userId)->count();
        $completed = WorkOrderModel::where('production_id', $userId)
            ->where('status', 'finish')
            ->count();
        
        $completionRate = $total > 0 ? round(($completed / $total) * 100, 2) : 0;

        // Average revision count
        $avgRevision = WorkOrderModel::where('production_id', $userId)
            ->avg('revision_count') ?? 0;

        // Work orders in revision status
        $inRevision = WorkOrderModel::where('production_id', $userId)
            ->where('status', 'revision')
            ->count();

        return [
            'completion_rate' => $completionRate,
            'avg_revision' => round($avgRevision, 2),
            'in_revision' => $inRevision,
            'total_assigned' => $total,
        ];
    }

    /**
     * Helper: Get status display text
     */
    private function getStatusDisplay($status)
    {
        $displays = [
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
     * Helper: Safely get time ago with error handling
     */
    private function getSafeTimeAgo($dateString)
    {
        try {
            if (empty($dateString)) {
                return 'Invalid date';
            }
            
            // If it's already a Carbon instance or DateTime
            if ($dateString instanceof \Carbon\Carbon || $dateString instanceof \DateTime) {
                return $dateString->diffForHumans();
            }
            
            return Carbon::parse($dateString)->diffForHumans();
            
        } catch (Exception $e) {
            return 'Invalid date';
        }
    }
}