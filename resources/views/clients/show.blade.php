@extends('layouts.app')

@section('title', 'Client Detail')
@section('page_label', 'Client Management')
@section('page_title', 'Client Detail')

@section('content')
    {{-- Flash message --}}
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-emerald-100 text-emerald-800 px-4 py-2 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header & Actions --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
        <div>
            <h2 class="text-xl font-semibold text-slate-800">
                {{ $client->name }}
            </h2>
            <div class="text-sm text-slate-500">
                @if($client->company_name)
                    {{ $client->company_name }}
                @endif
                @if($client->code)
                    <span class="text-slate-400 mx-1">•</span>
                    Code: {{ $client->code }}
                @endif
            </div>
        </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('clients.edit', $client) }}"
                class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-50">
                    Edit
                </a>
                <a href="{{ route('clients.index') }}"
                class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-50">
                    Back to List
                </a>
            </div>
        </div>

    {{-- Summary cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-xs font-semibold text-slate-500 uppercase mb-1">
                Status
            </div>
            <div class="text-base font-semibold">
                {{ ucfirst($client->status) }}
            </div>
            @if($client->segment)
                <div class="text-xs text-slate-500 mt-1">
                    Segment: <span class="font-medium">{{ $client->segment }}</span>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-xs font-semibold text-slate-500 uppercase mb-1">
                Total Services
            </div>
            <div class="text-2xl font-bold">
                {{ $client->services->count() }}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-xs font-semibold text-slate-500 uppercase mb-1">
                Last Interaction
            </div>
            <div class="text-sm">
                @php
                    $lastLog = $client->interactionLogs->first();
                @endphp

                @if($lastLog)
                    {{ $lastLog->created_at->format('d M Y H:i') }}
                    <div class="text-xs text-slate-500 mt-1">
                        Type: {{ ucfirst($lastLog->type) }}
                    </div>
                @else
                    <span class="text-slate-500 text-sm">No interaction logged yet.</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Detail Client Info --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <h3 class="text-sm font-semibold text-slate-800 mb-3">
            Client Information
        </h3>

        <div class="grid md:grid-cols-2 gap-4 text-sm">
            <div>
                <div class="text-xs text-slate-500">Email</div>
                <div class="text-slate-800">{{ $client->email ?? '-' }}</div>
            </div>
            <div>
                <div class="text-xs text-slate-500">Phone</div>
                <div class="text-slate-800">{{ $client->phone ?? '-' }}</div>
            </div>
            <div>
                <div class="text-xs text-slate-500">Industry</div>
                <div class="text-slate-800">{{ $client->industry ?? '-' }}</div>
            </div>
            <div>
                <div class="text-xs text-slate-500">Location</div>
                <div class="text-slate-800">
                    {{ $client->city ?? '-' }}
                    @if($client->country)
                        , {{ $client->country }}
                    @endif
                </div>
            </div>
            <div class="md:col-span-2">
                <div class="text-xs text-slate-500">Address</div>
                <div class="text-slate-800">{{ $client->address ?? '-' }}</div>
            </div>
        </div>

        @if($client->notes)
            <div class="mt-4 text-sm">
                <div class="text-xs text-slate-500 mb-1">Internal Notes</div>
                <div class="whitespace-pre-line text-slate-800">
                    {{ $client->notes }}
                </div>
            </div>
        @endif
    </div>

        {{-- Services list for this client --}}
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-slate-800">
                    Services for this Client
                </h3>
                <a href="{{ route('services.create', ['client_id' => $client->id]) }}"
                    class="text-xs rounded-lg bg-sky-600 px-3 py-1.5 text-white hover:bg-sky-700">
                        + Add Service
                </a>

            </div>

        @if($client->services->isEmpty())
            <p class="text-sm text-slate-500">
                No services registered for this client yet.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-3 py-2 text-left">Service</th>
                        <th class="px-3 py-2 text-left">Status</th>
                        <th class="px-3 py-2 text-left">Priority</th>
                        <th class="px-3 py-2 text-left">Due Date</th>
                        <th class="px-3 py-2 text-left">PIC</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($client->services as $service)
                        <tr class="border-b border-slate-100">
                            <td class="px-3 py-2">
                                {{ $service->name }}
                            </td>
                            <td class="px-3 py-2">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                    @if($service->status === 'completed') bg-emerald-100 text-emerald-700
                                    @elseif($service->status === 'in_progress') bg-sky-100 text-sky-700
                                    @elseif($service->status === 'on_hold') bg-amber-100 text-amber-700
                                    @elseif($service->status === 'cancelled') bg-slate-100 text-slate-600
                                    @else bg-slate-100 text-slate-700 @endif">
                                    {{ str_replace('_', ' ', ucfirst($service->status)) }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                {{ ucfirst($service->priority) }}
                            </td>
                            <td class="px-3 py-2">
                                {{ $service->due_date?->format('d M Y') ?? '-' }}
                                @if($service->is_overdue)
                                    <span class="ml-1 text-xs text-red-600">(Overdue)</span>
                                @endif
                            </td>
                            <td class="px-3 py-2">
                                {{ $service->pic?->name ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

        {{-- Interaction logs (ringkas, placeholder dulu) --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-slate-800">
                    Recent Interaction Logs
                </h3>
                <a href="#"
                class="text-xs rounded-lg border border-slate-300 px-3 py-1.5 hover:bg-slate-50">
                    View All (nanti)
                </a>
            </div>

        @if($client->interactionLogs->isEmpty())
            <p class="text-sm text-slate-500">
                No interaction logs yet for this client.
            </p>
        @else
            <ul class="divide-y divide-slate-100 text-sm">
                @foreach($client->interactionLogs->take(5) as $log)
                    <li class="py-2 flex items-start justify-between gap-3">
                        <div>
                            <div class="text-xs text-slate-500">
                                {{ $log->created_at->format('d M Y H:i') }}
                                • {{ ucfirst($log->type) }}
                            </div>
                            <div class="text-slate-800">
                                {{ \Illuminate\Support\Str::limit($log->notes, 120) }}
                            </div>
                            @if($log->next_action)
                                <div class="text-xs text-slate-500 mt-1">
                                    Next: {{ \Illuminate\Support\Str::limit($log->next_action, 80) }}
                                    @if($log->next_action_due_at)
                                        • Due: {{ $log->next_action_due_at->format('d M Y H:i') }}
                                        @if($log->is_overdue)
                                            <span class="text-red-600 font-medium"> (Overdue)</span>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="text-xs text-slate-400">
                            By: {{ $log->user?->name ?? '-' }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
