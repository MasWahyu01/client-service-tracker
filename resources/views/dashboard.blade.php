@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_label', 'Overview')
@section('page_title', 'Dashboard')

@section('content')
    {{-- Summary cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        {{-- Active Clients --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-xs font-semibold text-slate-500 uppercase mb-1">
                Active Clients
            </div>
            <div class="text-3xl font-bold text-slate-800">
                {{ $metrics['total_active_clients'] ?? 0 }}
            </div>
            <div class="text-xs text-slate-400 mt-1">
                Total clients with status <span class="font-semibold">Active</span>.
            </div>
        </div>

        {{-- Services In Progress --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-xs font-semibold text-slate-500 uppercase mb-1">
                Services In Progress
            </div>
            <div class="text-3xl font-bold text-slate-800">
                {{ $metrics['services_in_progress'] ?? 0 }}
            </div>
            <div class="text-xs text-slate-400 mt-1">
                Services currently in <span class="font-semibold">In Progress</span> state.
            </div>
        </div>

        {{-- Overdue Items --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-xs font-semibold text-red-500 uppercase mb-1">
                Overdue Items
            </div>
            <div class="text-3xl font-bold text-red-600">
                {{ ($metrics['overdue_services'] ?? 0) + ($metrics['overdue_actions'] ?? 0) }}
            </div>
            <div class="text-xs text-slate-400 mt-1">
                {{ $metrics['overdue_services'] ?? 0 }} overdue services,
                {{ $metrics['overdue_actions'] ?? 0 }} overdue next actions.
            </div>
        </div>
    </div>

    {{-- Overdue sections --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Overdue Services --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-800">
                    Overdue Services
                </h2>
                <span class="text-xs text-slate-500">
                    {{ $metrics['overdue_services'] ?? 0 }} items
                </span>
            </div>

            @if(($overdueServices ?? collect())->isEmpty())
                <p class="text-sm text-slate-500">
                    No overdue services. Great job! 🎉
                </p>
            @else
                <ul class="divide-y divide-slate-100 text-sm">
                    @foreach($overdueServices as $service)
                        <li class="py-2 flex items-start justify-between gap-3">
                            <div>
                                <div class="font-medium text-slate-800">
                                    {{ $service->name }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    Client: {{ $service->client?->name ?? '-' }}
                                </div>
                                <div class="text-xs text-slate-500 mt-1">
                                    Due: {{ $service->due_date?->format('d M Y') ?? '-' }}
                                    <span class="text-red-600 font-semibold"> (Overdue)</span>
                                    • Status: {{ str_replace('_', ' ', ucfirst($service->status)) }}
                                </div>
                            </div>
                            <div class="text-xs text-slate-400 text-right">
                                Priority: <span class="font-semibold">{{ ucfirst($service->priority) }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Overdue Next Actions --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-800">
                    Overdue Next Actions
                </h2>
                <span class="text-xs text-slate-500">
                    {{ $metrics['overdue_actions'] ?? 0 }} items
                </span>
            </div>

            @if(($overdueActions ?? collect())->isEmpty())
                <p class="text-sm text-slate-500">
                    No overdue follow-up actions.
                </p>
            @else
                <ul class="divide-y divide-slate-100 text-sm">
                    @foreach($overdueActions as $log)
                        <li class="py-2 flex items-start justify-between gap-3">
                            <div>
                                <div class="font-medium text-slate-800">
                                    {{ $log->client?->name ?? '-' }}
                                </div>
                                <div class="text-xs text-slate-500">
                                    {{ ucfirst($log->type) }} •
                                    Due: {{ $log->next_action_due_at?->format('d M Y H:i') }}
                                    <span class="text-red-600 font-semibold"> (Overdue)</span>
                                </div>
                                @if($log->next_action)
                                    <div class="text-xs text-slate-500 mt-1">
                                        Next: {{ \Illuminate\Support\Str::limit($log->next_action, 80) }}
                                    </div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

<div class="bg-white rounded-xl shadow-sm p-4 mt-4">
    <h2 class="text-base font-semibold text-slate-800 mb-4">
        System Overview
    </h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
            <h3 class="text-sm font-semibold text-slate-700 mb-2">
                Services per Month
            </h3>
            <canvas id="servicesByMonthChart" class="w-full h-64"></canvas>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-slate-700 mb-2">
                Services by Status
            </h3>
            <canvas id="servicesByStatusChart" class="w-full h-64"></canvas>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (!window.Chart) {
        console.error('Chart.js not found');
        return;
    }

    // Data dari PHP
    const servicesByMonth = @json($chartData['services_by_month']);
    const servicesByStatus = @json($chartData['services_by_status']);



    // Line chart: Services per Month
    const monthCtx = document.getElementById('servicesByMonthChart');
    if (monthCtx) {
        new Chart(monthCtx, {
            type: 'line',
            data: {
                labels: servicesByMonth.labels,
                datasets: [{
                    label: 'Services per Month',
                    data: servicesByMonth.data,
                    tension: 0.3,
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                    }
                }
            }
        });
    }

    // Doughnut chart: Services by Status
    const statusCtx = document.getElementById('servicesByStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: servicesByStatus.labels,
                datasets: [{
                    data: servicesByStatus.data,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                }
            }
        });
    }
});
</script>
@endpush
@endsection
