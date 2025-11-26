<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Service;
use App\Models\InteractionLog;

class DashboardService
{
    public function getSummaryMetrics(): array
    {
        $totalActiveClients   = Client::active()->count();
        $servicesInProgress   = Service::inProgress()->count();
        $overdueServices      = Service::overdue()->count();

        $overdueActions = InteractionLog::whereNotNull('next_action_due_at')
            ->where('next_action_due_at', '<', now())
            ->count();

        return [
            'total_active_clients' => $totalActiveClients,
            'services_in_progress' => $servicesInProgress,
            'overdue_services'     => $overdueServices,
            'overdue_actions'      => $overdueActions,
        ];
    }

    public function getOverdueServices(int $limit = 5)
    {
        return Service::with('client')
            ->overdue()
            ->orderBy('due_date')
            ->limit($limit)
            ->get();
    }

    public function getOverdueActions(int $limit = 5)
    {
        return InteractionLog::with('client')
            ->whereNotNull('next_action_due_at')
            ->where('next_action_due_at', '<', now())
            ->orderBy('next_action_due_at')
            ->limit($limit)
            ->get();
    }
public function getChartData(): array
{
    // Services per month (simple grouping by year-month)
    $servicesPerMonthRaw = \App\Models\Service::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, COUNT(*) as total')
        ->groupBy('ym')
        ->orderBy('ym')
        ->limit(12)
        ->get();

    $servicesPerMonthLabels = $servicesPerMonthRaw->pluck('ym')->toArray();
    $servicesPerMonthData   = $servicesPerMonthRaw->pluck('total')->toArray();

    // Services by status
    $statuses = ['new', 'in_progress', 'on_hold', 'completed', 'cancelled'];

    $servicesByStatusRaw = \App\Models\Service::selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

    $servicesByStatusData = [];
    foreach ($statuses as $status) {
        $servicesByStatusData[] = $servicesByStatusRaw[$status] ?? 0;
    }

    return [
        'services_by_month' => [
            'labels' => $servicesPerMonthLabels,
            'data'   => $servicesPerMonthData,
        ],
        'services_by_status' => [
            'labels' => array_map(function ($s) {
                return str_replace('_', ' ', ucfirst($s));
            }, $statuses),
            'data'   => $servicesByStatusData,
        ],
    ];
}

}
