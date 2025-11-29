@extends('layouts.app')

@section('title', 'Services')
@section('page_label', 'Service Management')
@section('page_title', 'Services')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-semibold text-slate-800">Services</h3>

        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('services.index') }}" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..."
                       class="rounded-lg border border-slate-300 px-3 py-1 text-sm">
                <select name="status" class="rounded-lg border border-slate-300 px-2 py-1 text-sm">
                    <option value="">All status</option>
                    <option value="new" @selected(request('status') == 'new')>New</option>
                    <option value="in_progress" @selected(request('status') == 'in_progress')>In Progress</option>
                    <option value="on_hold" @selected(request('status') == 'on_hold')>On Hold</option>
                    <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                    <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelled</option>
                </select>

                <button type="submit" class="rounded-lg bg-sky-600 text-white px-3 py-1 text-sm">
                    Filter
                </button>
            </form>

            <a href="{{ route('services.create') }}" class="rounded-lg bg-emerald-600 text-white px-3 py-1 text-sm">
                + New Service
            </a>
        </div>
    </div>

    @if($services->isEmpty())
        <div class="text-sm text-slate-500 p-6">
            No services found.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-3 py-2 text-left">#</th>
                        <th class="px-3 py-2 text-left">Name</th>
                        <th class="px-3 py-2 text-left">Client</th>
                        <th class="px-3 py-2 text-left">Status</th>
                        <th class="px-3 py-2 text-left">Priority</th>
                        <th class="px-3 py-2 text-left">Due Date</th>
                        <th class="px-3 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr class="border-b border-slate-100">
                            <td class="px-3 py-2">{{ $service->id }}</td>
                            <td class="px-3 py-2">{{ $service->name }}</td>
                            <td class="px-3 py-2">{{ $service->client?->name ?? '-' }}</td>
                            <td class="px-3 py-2">{{ str_replace('_',' ', ucfirst($service->status)) }}</td>
                            <td class="px-3 py-2">{{ ucfirst($service->priority) }}</td>
                            <td class="px-3 py-2">{{ $service->due_date?->format('d M Y') ?? '-' }}</td>
                            <td class="px-3 py-2">
                                <a href="{{ route('clients.show', $service->client_id) }}" class="text-xs text-sky-600 hover:underline">View Client</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $services->links() }}
        </div>
    @endif
</div>
@endsection
