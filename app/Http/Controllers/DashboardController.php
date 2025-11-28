<?php

namespace App\Http\Controllers;

use App\Services\AdminDashboardService;
use App\Services\AsServiceDashboardService;
use App\Services\ProductionDashboardService;
use App\Services\SalesDashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $adminDashboardService;
    protected $asServiceDashboardService;
    protected $productionDashboardService;
    protected $salesDashboardService;

    public function __construct(
        AdminDashboardService $adminDashboardService,
        AsServiceDashboardService $asServiceDashboardService,
        ProductionDashboardService $productionDashboardService,
        SalesDashboardService $salesDashboardService
    ) {
        $this->adminDashboardService = $adminDashboardService;
        $this->asServiceDashboardService = $asServiceDashboardService;
        $this->productionDashboardService = $productionDashboardService;
        $this->salesDashboardService = $salesDashboardService;
    }

    public function index()
    {
        $data = [];
        $user = auth()->user();

        // Prepare data based on role
        if ($user->hasRole('admin')) {
            $data = $this->adminDashboardService->getDashboardStats();
        } elseif ($user->hasRole('asservice')) {
            $data = $this->asServiceDashboardService->getDashboardStats();
        } elseif ($user->hasRole('production')) {
            $data = $this->productionDashboardService->getDashboardStats($user->id);
        } elseif ($user->hasRole('sales')) {
            $data = $this->salesDashboardService->getDashboardStats($user->id);
        }

        return view('dashboard.index', $data);
    }
}