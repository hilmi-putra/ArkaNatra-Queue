<?php

namespace App\Services;

use App\Models\WorkOrderModel;
use Carbon\Carbon;
use Exception;

class SalesDashboardService
{
    /**
     * Get all dashboard statistics for Sales role
     */
    public function getDashboardStats($userId)
    {
        return [
            'metrics' => $this->getMetrics($userId),
            'recentSales' => $this->getRecentSales($userId),
            'statusBreakdown' => $this->getStatusBreakdown($userId),
            'performanceMetrics' => $this->getPerformanceMetrics($userId),
            'priorityItems' => $this->getPriorityItems($userId),
        ];
    }

    /**
     * Get metrics specific to Sales user
     */
    private function getMetrics($userId)
    {
        // Total work orders created by this sales user
        $totalSales = WorkOrderModel::where('sales_id', $userId)->count();
        
        // Completed (sold) work orders
        $totalFinish = WorkOrderModel::where('sales_id', $userId)
            ->where('status', 'finish')
            ->count();
        
        // In progress work orders
        $totalProgress = WorkOrderModel::where('sales_id', $userId)
            ->where('status', 'progress')
            ->count();
        
        // Pending work orders (awaiting customer action or review)
        $totalPending = WorkOrderModel::where('sales_id', $userId)
            ->where('status', 'pending')
            ->count();

        return [
            'total_sales' => $totalSales,
            'total_finish' => $totalFinish,
            'total_progress' => $totalProgress,
            'total_pending' => $totalPending,
        ];
    }

    /**
     * Get recent sales/work orders
     */
    private function getRecentSales($userId)
    {
        return WorkOrderModel::where('sales_id', $userId)
            ->with(['customer', 'workType', 'productionUser'])
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
     * Get status breakdown for this sales user
     */
    private function getStatusBreakdown($userId)
    {
        $statuses = ['validate', 'queue', 'pending', 'progress', 'revision', 'finish'];
        
        return collect($statuses)->map(function ($status) use ($userId) {
            $count = WorkOrderModel::where('sales_id', $userId)
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
        $total = WorkOrderModel::where('sales_id', $userId)->count();
        $completed = WorkOrderModel::where('sales_id', $userId)
            ->where('status', 'finish')
            ->count();
        
        $completionRate = $total > 0 ? round(($completed / $total) * 100, 2) : 0;

        // Average completion time (days from creation to finish)
        $avgCompletionDays = WorkOrderModel::where('sales_id', $userId)
            ->where('status', 'finish')
            ->select('created_at', 'date_completed')
            ->get()
            ->map(function ($item) {
                if ($item->date_completed) {
                    $createdAt = $this->parseDateSafely($item->created_at);
                    $completedAt = $this->parseDateSafely($item->date_completed);
                    
                    if ($createdAt && $completedAt) {
                        return $createdAt->diffInDays($completedAt);
                    }
                }
                return 0;
            })
            ->filter() // Remove null values
            ->avg() ?? 0;

        return [
            'completion_rate' => $completionRate,
            'avg_completion_days' => round($avgCompletionDays, 1),
            'total_sales' => $total,
            'total_completed' => $completed,
        ];
    }

    /**
     * Get priority items (pending sales, high revision, etc.)
     */
    private function getPriorityItems($userId)
    {
        return WorkOrderModel::where('sales_id', $userId)
            ->where(function ($query) {
                $query->where('status', 'pending') // Pending items
                    ->orWhere('status', 'revision') // In revision
                    ->orWhere('fast_track', true); // Fast track items
            })
            ->with(['customer', 'workType', 'productionUser'])
            ->orderByDesc('updated_at')
            ->limit(8)
            ->get()
            ->map(function ($item) {
                $item->priority_reason = $this->getPriorityReason($item);
                $item->time_ago = $this->getSafeTimeAgo($item->getAttributes()['updated_at']);
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
        if ($workOrder->status === 'pending') {
            return 'Menunggu Tindakan';
        }
        
        if ($workOrder->status === 'revision') {
            return 'Dalam Revisi';
        }

        if ($workOrder->fast_track) {
            return 'Fast Track Priority';
        }

        return 'Regular';
    }

    /**
     * Helper: Safely parse date with error handling
     */
    private function parseDateSafely($dateString)
    {
        try {
            // If it's already a Carbon instance or DateTime
            if ($dateString instanceof \Carbon\Carbon || $dateString instanceof \DateTime) {
                return Carbon::instance($dateString);
            }
            
            // If it's null or empty
            if (empty($dateString)) {
                return null;
            }
            
            // Try to parse as ISO format first (most reliable)
            if (preg_match('/^\d{4}-\d{2}-\d{2}/', $dateString)) {
                return Carbon::parse($dateString);
            }
            
            // For Indonesian dates or other formats, try with locale setting
            // Set locale to English to avoid Indonesian day/month parsing issues
            $backupLocale = Carbon::getLocale();
            Carbon::setLocale('en');
            
            $parsedDate = Carbon::parse($dateString);
            
            // Restore original locale
            Carbon::setLocale($backupLocale);
            
            return $parsedDate;
            
        } catch (Exception $e) {
            // Log the error for debugging
            \Log::warning('Failed to parse date: ' . $dateString, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return null;
        }
    }

    /**
     * Helper: Safely get time ago with error handling
     */
    private function getSafeTimeAgo($dateString)
    {
        $date = $this->parseDateSafely($dateString);
        
        if ($date) {
            return $date->diffForHumans();
        }
        
        return 'Invalid date';
    }
}