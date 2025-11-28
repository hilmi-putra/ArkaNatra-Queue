<?php

namespace App\Services;

use App\Models\User;
use App\Models\CustomerModel;
use App\Models\WorkOrderModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    /**
     * Get all dashboard statistics for admin
     */
    public function getDashboardStats()
    {
        return [
            'metrics' => $this->getMetrics(),
            'longestMigrations' => $this->getLongestMigrations(),
            'workOrdersChartData' => $this->getWorkOrdersChartData(),
            'priorityItems' => $this->getPriorityItems(),
            'teamPerformance' => $this->getTeamPerformance(),
            'recentActivities' => $this->getRecentActivities(),
            'statusDistribution' => $this->getStatusDistribution(),
        ];
    }

    /**
     * Get key metrics for dashboard
     */
    private function getMetrics()
    {
        $totalUsers = User::count();
        $totalCustomers = CustomerModel::count();
        
        $workOrderStats = WorkOrderModel::select('status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $totalWorkOrders = WorkOrderModel::count();
        $totalQueue = $workOrderStats['queue'] ?? 0;
        $totalRevision = $workOrderStats['revision'] ?? 0;
        $totalMigration = $workOrderStats['migration'] ?? 0;
        $totalFinish = $workOrderStats['finish'] ?? 0;
        $totalPending = $workOrderStats['pending'] ?? 0;
        $totalProgress = $workOrderStats['progress'] ?? 0;

        return [
            'total_users' => $totalUsers,
            'total_customers' => $totalCustomers,
            'total_work_orders' => $totalWorkOrders,
            'total_queue' => $totalQueue,
            'total_revision' => $totalRevision,
            'total_migration' => $totalMigration,
            'total_finish' => $totalFinish,
            'total_pending' => $totalPending,
            'total_progress' => $totalProgress,
            'total_validate' => $workOrderStats['validate'] ?? 0,
        ];
    }

    /**
     * Get work orders with longest migration duration
     */
    private function getLongestMigrations()
    {
        $migrations = WorkOrderModel::where('status', 'migration')
            ->orWhere(function ($query) {
                // Pekerjaan yang sudah selesai tapi durasi migrasi panjang
                $query->where('status', 'finish')
                    ->whereNotNull('date_migration');
            })
            ->with(['customer', 'salesUser', 'productionUser'])
            ->limit(5)
            ->get()
            ->map(function ($item) {
                // Get raw dates from database without accessors
                $migrationDate = $item->getAttributes()['date_migration'] ?? null;
                $completedDate = $item->getAttributes()['date_completed'] ?? null;
                
                $item->migration_duration = $this->calculateDuration($migrationDate, $completedDate);
                $item->migration_days = $migrationDate && $completedDate
                    ? Carbon::parse($migrationDate)->diffInDays(Carbon::parse($completedDate))
                    : 0;
                return $item;
            })
            ->sortByDesc('migration_days')
            ->take(5);

        return $migrations;
    }

    /**
     * Get work orders chart data (last 30 days by date)
     */
    private function getWorkOrdersChartData()
    {
        $days = 30;
        $startDate = Carbon::now()->subDays($days);

        $data = WorkOrderModel::selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill missing dates with 0
        $labels = [];
        $values = [];
        
        for ($i = $days; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('d M');
            $values[] = $data[$date] ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $values,
        ];
    }

    /**
     * Get priority items (high revision count, long pending, fast track)
     */
    private function getPriorityItems()
    {
        $highPriority = WorkOrderModel::where(function ($query) {
            $query->where('revision_count', '>=', 2)
                ->orWhere('fast_track', true)
                ->orWhere(function ($subQuery) {
                    // Pekerjaan yang pending lebih dari 7 hari
                    $subQuery->where('status', 'pending')
                        ->where('date_queue', '<=', Carbon::now()->subDays(7));
                });
        })
            ->with(['customer', 'workType', 'salesUser', 'productionUser'])
            ->orderByDesc('revision_count')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->priority_reason = $this->determinePriorityReason($item);
                
                // Get raw date from database without accessor
                $dateQueue = $item->getAttributes()['date_queue'] ?? null;
                $item->pending_days = $item->status === 'pending' && $dateQueue
                    ? Carbon::parse($dateQueue)->diffInDays(Carbon::now())
                    : null;
                return $item;
            });

        return $highPriority;
    }

    /**
     * Get team performance metrics
     */
    private function getTeamPerformance()
    {
        // Production team performance
        $productionPerformance = WorkOrderModel::selectRaw('production_id')
            ->selectRaw('COUNT(*) as total_works')
            ->selectRaw('SUM(CASE WHEN status = "finish" THEN 1 ELSE 0 END) as completed_works')
            ->selectRaw('AVG(CASE WHEN status = "revision" THEN revision_count ELSE 0 END) as avg_revision')
            ->where('production_id', '!=', null)
            ->groupBy('production_id')
            ->with('productionUser')
            ->get()
            ->map(function ($item) {
                if ($item->productionUser) {
                    $item->completion_rate = $item->total_works > 0 
                        ? round(($item->completed_works / $item->total_works) * 100, 2) 
                        : 0;
                    return $item;
                }
            })
            ->filter()
            ->sortByDesc('completion_rate')
            ->take(5);

        // Sales team performance
        $salesPerformance = WorkOrderModel::selectRaw('sales_id')
            ->selectRaw('COUNT(*) as total_works')
            ->selectRaw('SUM(CASE WHEN status = "finish" THEN 1 ELSE 0 END) as completed_works')
            ->where('sales_id', '!=', null)
            ->groupBy('sales_id')
            ->with('salesUser')
            ->get()
            ->map(function ($item) {
                if ($item->salesUser) {
                    $item->completion_rate = $item->total_works > 0 
                        ? round(($item->completed_works / $item->total_works) * 100, 2) 
                        : 0;
                    return $item;
                }
            })
            ->filter()
            ->sortByDesc('completion_rate')
            ->take(5);

        return [
            'production' => $productionPerformance,
            'sales' => $salesPerformance,
        ];
    }

    /**
     * Get recent activities
     */
    private function getRecentActivities()
    {
        return WorkOrderModel::with(['customer', 'workType', 'salesUser', 'productionUser'])
            ->orderByDesc('updated_at')
            ->limit(15)
            ->get()
            ->map(function ($item) {
                $item->activity_description = $this->getActivityDescription($item);
                // Add raw timestamp and calculated time ago for view
                $rawUpdatedAt = $item->getAttributes()['updated_at'] ?? null;
                $item->raw_updated_at = $rawUpdatedAt;
                $item->time_ago = $rawUpdatedAt 
                    ? Carbon::parse($rawUpdatedAt)->diffForHumans() 
                    : '-';
                return $item;
            });
    }

    /**
     * Get status distribution
     */
    private function getStatusDistribution()
    {
        $distribution = WorkOrderModel::selectRaw('status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $total = WorkOrderModel::count();

        return collect($distribution)->map(function ($count, $status) use ($total) {
            return [
                'status' => $status,
                'count' => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100, 2) : 0,
            ];
        })->sortByDesc('count')->values();
    }

    /**
     * Helper: Calculate duration between two dates
     */
    private function calculateDuration($startDate, $endDate)
    {
        if (!$startDate || !$endDate) {
            return null;
        }

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        $days = $end->diffInDays($start);
        
        if ($days < 1) {
            $hours = $end->diffInHours($start);
            return "{$hours} jam";
        }

        return "{$days} hari";
    }

    /**
     * Helper: Determine priority reason for work order
     */
    private function determinePriorityReason($workOrder)
    {
        $reasons = [];

        if ($workOrder->revision_count >= 2) {
            $reasons[] = "Revisi {$workOrder->revision_count}x";
        }

        if ($workOrder->fast_track) {
            $reasons[] = "Fast Track";
        }

        if ($workOrder->status === 'pending') {
            // Get raw date from database without accessor
            $dateQueue = $workOrder->getAttributes()['date_queue'] ?? null;
            if ($dateQueue) {
                $pendingDays = Carbon::parse($dateQueue)->diffInDays(Carbon::now());
                if ($pendingDays >= 7) {
                    $reasons[] = "Pending {$pendingDays} hari";
                }
            }
        }

        return implode(', ', $reasons) ?: 'Regular Priority';
    }

    /**
     * Helper: Get activity description
     */
    private function getActivityDescription($workOrder)
    {
        $customer = $workOrder->customer?->name ?? 'Unknown Customer';
        $workType = $workOrder->workType?->work_type ?? 'Unknown';
        $status = $workOrder->status;

        $statusLabels = [
            'validate' => 'Divalidasi',
            'queue' => 'Dalam Antrian',
            'pending' => 'Tertunda',
            'progress' => 'Sedang Dikerjakan',
            'revision' => 'Revisi',
            'migration' => 'Migrasi',
            'finish' => 'Selesai',
        ];

        $statusLabel = $statusLabels[$status] ?? $status;

        return "{$customer} - {$workType} ({$statusLabel})";
    }
}
