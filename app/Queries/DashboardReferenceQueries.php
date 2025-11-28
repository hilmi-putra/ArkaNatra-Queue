<?php

/**
 * Reference Queries untuk Dashboard Admin
 * 
 * File ini berisi contoh-contoh query yang digunakan dalam AdminDashboardService
 * untuk keperluan debugging, testing, atau pengembangan lebih lanjut.
 */

namespace App\Queries;

use App\Models\User;
use App\Models\CustomerModel;
use App\Models\WorkOrderModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardReferenceQueries
{
    /**
     * Query: Total Users
     * Returns: Integer count
     * 
     * SELECT COUNT(*) FROM users;
     */
    public static function totalUsers()
    {
        return User::count();
    }

    /**
     * Query: Total Customers
     * Returns: Integer count
     * 
     * SELECT COUNT(*) FROM table_customer;
     */
    public static function totalCustomers()
    {
        return CustomerModel::count();
    }

    /**
     * Query: Work Orders by Status Breakdown
     * Returns: Collection with status as key, count as value
     * 
     * SELECT status, COUNT(*) as count 
     * FROM table_work_orders 
     * GROUP BY status;
     */
    public static function workOrdersByStatus()
    {
        return WorkOrderModel::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');
    }

    /**
     * Query: Longest Migrations (still in migration or finished with long duration)
     * Returns: Collection of WorkOrder models
     * 
     * SELECT * FROM table_work_orders 
     * WHERE status = 'migration' 
     *    OR (status = 'finish' AND date_migration IS NOT NULL)
     * ORDER BY DATEDIFF(day, date_migration, date_completed) DESC
     * LIMIT 5;
     */
    public static function longestMigrations()
    {
        return WorkOrderModel::where('status', 'migration')
            ->orWhere(function ($query) {
                $query->where('status', 'finish')
                    ->whereNotNull('date_migration');
            })
            ->with(['customer', 'salesUser', 'productionUser'])
            ->limit(5)
            ->get();
    }

    /**
     * Query: Work Orders Trend - Last 30 Days
     * Returns: Array with dates as keys, counts as values
     * 
     * SELECT DATE(created_at) as date, COUNT(*) as count 
     * FROM table_work_orders 
     * WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
     * GROUP BY DATE(created_at)
     * ORDER BY date ASC;
     */
    public static function workOrdersTrend30Days()
    {
        $startDate = Carbon::now()->subDays(30);
        
        return WorkOrderModel::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');
    }

    /**
     * Query: High Priority Items
     * Criteria:
     * - Revision count >= 2
     * - Fast track = true
     * - Status pending AND date_queue <= 7 days ago
     * 
     * SELECT * FROM table_work_orders 
     * WHERE (revision_count >= 2 
     *    OR fast_track = 1 
     *    OR (status = 'pending' AND date_queue <= DATE_SUB(NOW(), INTERVAL 7 DAY)))
     * ORDER BY revision_count DESC
     * LIMIT 10;
     */
    public static function highPriorityItems()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);
        
        return WorkOrderModel::where(function ($query) use ($sevenDaysAgo) {
            $query->where('revision_count', '>=', 2)
                ->orWhere('fast_track', true)
                ->orWhere(function ($subQuery) use ($sevenDaysAgo) {
                    $subQuery->where('status', 'pending')
                        ->where('date_queue', '<=', $sevenDaysAgo);
                });
        })
            ->with(['customer', 'workType', 'salesUser', 'productionUser'])
            ->orderByDesc('revision_count')
            ->limit(10)
            ->get();
    }

    /**
     * Query: Production Team Performance
     * Returns: Collection with team member stats
     * 
     * SELECT 
     *     production_id,
     *     COUNT(*) as total_works,
     *     SUM(CASE WHEN status = 'finish' THEN 1 ELSE 0 END) as completed_works,
     *     AVG(CASE WHEN status = 'revision' THEN revision_count ELSE 0 END) as avg_revision
     * FROM table_work_orders
     * WHERE production_id IS NOT NULL
     * GROUP BY production_id
     * ORDER BY (completed_works / total_works) DESC;
     */
    public static function productionTeamPerformance()
    {
        return WorkOrderModel::selectRaw('
            production_id,
            COUNT(*) as total_works,
            SUM(CASE WHEN status = "finish" THEN 1 ELSE 0 END) as completed_works,
            AVG(CASE WHEN status = "revision" THEN revision_count ELSE 0 END) as avg_revision
        ')
            ->where('production_id', '!=', null)
            ->groupBy('production_id')
            ->with('productionUser')
            ->get();
    }

    /**
     * Query: Sales Team Performance
     * Returns: Collection with team member stats
     * 
     * SELECT 
     *     sales_id,
     *     COUNT(*) as total_works,
     *     SUM(CASE WHEN status = 'finish' THEN 1 ELSE 0 END) as completed_works
     * FROM table_work_orders
     * WHERE sales_id IS NOT NULL
     * GROUP BY sales_id
     * ORDER BY (completed_works / total_works) DESC;
     */
    public static function salesTeamPerformance()
    {
        return WorkOrderModel::selectRaw('
            sales_id,
            COUNT(*) as total_works,
            SUM(CASE WHEN status = "finish" THEN 1 ELSE 0 END) as completed_works
        ')
            ->where('sales_id', '!=', null)
            ->groupBy('sales_id')
            ->with('salesUser')
            ->get();
    }

    /**
     * Query: Recent Activities (Latest Updated Work Orders)
     * Returns: Collection of WorkOrder models ordered by update date
     * 
     * SELECT * FROM table_work_orders 
     * ORDER BY updated_at DESC 
     * LIMIT 15;
     */
    public static function recentActivities()
    {
        return WorkOrderModel::with(['customer', 'workType', 'salesUser', 'productionUser'])
            ->orderByDesc('updated_at')
            ->limit(15)
            ->get();
    }

    /**
     * Query: Status Distribution
     * Returns: Collection with status, count, and percentage
     * 
     * SELECT status, COUNT(*) as count, 
     *        (COUNT(*) / (SELECT COUNT(*) FROM table_work_orders)) * 100 as percentage
     * FROM table_work_orders
     * GROUP BY status
     * ORDER BY count DESC;
     */
    public static function statusDistribution()
    {
        $total = WorkOrderModel::count();
        
        return WorkOrderModel::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->map(function ($count) use ($total) {
                return [
                    'count' => $count,
                    'percentage' => $total > 0 ? round(($count / $total) * 100, 2) : 0,
                ];
            });
    }

    /**
     * Query: Work Orders Pending More Than X Days
     * Returns: Collection of WorkOrder models
     * 
     * SELECT * FROM table_work_orders 
     * WHERE status = 'pending' 
     *   AND date_queue <= DATE_SUB(NOW(), INTERVAL 7 DAY);
     */
    public static function pendingMoreThanDays($days = 7)
    {
        $dateThreshold = Carbon::now()->subDays($days);
        
        return WorkOrderModel::where('status', 'pending')
            ->where('date_queue', '<=', $dateThreshold)
            ->with(['customer', 'workType', 'productionUser'])
            ->get();
    }

    /**
     * Query: High Revision Count Items
     * Returns: Collection of WorkOrder models
     * 
     * SELECT * FROM table_work_orders 
     * WHERE revision_count >= 2
     * ORDER BY revision_count DESC;
     */
    public static function highRevisionItems()
    {
        return WorkOrderModel::where('revision_count', '>=', 2)
            ->with(['customer', 'workType', 'productionUser'])
            ->orderByDesc('revision_count')
            ->get();
    }

    /**
     * Query: Fast Track Work Orders
     * Returns: Collection of WorkOrder models
     * 
     * SELECT * FROM table_work_orders 
     * WHERE fast_track = 1;
     */
    public static function fastTrackItems()
    {
        return WorkOrderModel::where('fast_track', true)
            ->with(['customer', 'workType', 'productionUser'])
            ->get();
    }

    /**
     * Query: Work Orders Completed Today
     * Returns: Count of completed work orders
     * 
     * SELECT COUNT(*) FROM table_work_orders 
     * WHERE status = 'finish' 
     *   AND DATE(date_completed) = CURDATE();
     */
    public static function completedToday()
    {
        return WorkOrderModel::where('status', 'finish')
            ->whereDate('date_completed', Carbon::today())
            ->count();
    }

    /**
     * Query: Average Work Order Duration
     * Returns: Average duration in days
     * 
     * SELECT AVG(DATEDIFF(day, date_received, date_completed)) as avg_duration
     * FROM table_work_orders
     * WHERE date_completed IS NOT NULL;
     */
    public static function averageDuration()
    {
        $workOrders = WorkOrderModel::whereNotNull('date_completed')
            ->whereNotNull('date_received')
            ->get();
        
        $totalDays = 0;
        $count = 0;
        
        foreach ($workOrders as $order) {
            $days = Carbon::parse($order->date_received)
                ->diffInDays(Carbon::parse($order->date_completed));
            $totalDays += $days;
            $count++;
        }
        
        return $count > 0 ? $totalDays / $count : 0;
    }

    /**
     * Query: Work Orders by Division
     * Returns: Collection with division name and count
     * 
     * SELECT d.name, COUNT(*) as count 
     * FROM table_work_orders wo
     * JOIN table_division d ON wo.division_id = d.id
     * GROUP BY d.id, d.name;
     */
    public static function workOrdersByDivision()
    {
        return WorkOrderModel::selectRaw('division_id, COUNT(*) as count')
            ->with('division')
            ->groupBy('division_id')
            ->get();
    }

    /**
     * Query: Work Orders by Work Type
     * Returns: Collection with work type name and count
     * 
     * SELECT wt.work_type, COUNT(*) as count 
     * FROM table_work_orders wo
     * JOIN table_work_types wt ON wo.work_type_id = wt.id
     * GROUP BY wt.id, wt.work_type;
     */
    public static function workOrdersByType()
    {
        return WorkOrderModel::selectRaw('work_type_id, COUNT(*) as count')
            ->with('workType')
            ->groupBy('work_type_id')
            ->get();
    }
}
