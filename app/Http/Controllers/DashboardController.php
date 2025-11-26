<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {
        //
    }
    public function index()
{
    $metrics         = $this->dashboardService->getSummaryMetrics();
    $overdueServices = $this->dashboardService->getOverdueServices(5);
    $overdueActions  = $this->dashboardService->getOverdueActions(5);
    $chartData       = $this->dashboardService->getChartData();

    return view('dashboard', compact(
        'metrics',
        'overdueServices',
        'overdueActions',
        'chartData',
    ));
}
}
