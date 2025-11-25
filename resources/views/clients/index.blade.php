@extends('layouts.app')

@section('title', 'Clients')
@section('page_label', 'Client Management')
@section('page_title', 'Clients')

@section('content')
    {{-- Flash message --}}
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-emerald-100 text-emerald-800 px-4 py-2 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
        <form method="GET" action="{{ route('clients.index') }}" class="flex flex-wrap items-center gap-2 text-sm">
            <input
                type="text"
                name="q"
                value="{{ $filters['q'] ?? '' }}"
                placeholder="Search name, email, company..."
                class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
            >

            <select
                name="status"
                class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
            >
                <option value="">All Status</option>
                <option value="prospect" @selected(($filters['status'] ?? '') === 'prospect')>Prospect</option>
                <option value="active" @selected(($filters['status'] ?? '') === 'active')>Active</option>
                <option value="inactive" @selected(($filters['status'] ?? '') === 'inactive')>Inactive</option>
            </select>

            <input
                type="text"
                name="segment"
                value="{{ $filters['segment'] ?? '' }}"
                placeholder="Segment (VIP, SME...)"
                class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
            >

            <button
                type="submit"
                class="rounded-lg bg-sky-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-sky-700"
            >
                Filter
            </button>

            <a href="{{ route('clients.index') }}"
                class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm text-slate-600 hover:bg-slate-50">
                Reset
            </a>
        </form>

        <a href="{{ route('clients.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
            + New Client
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Company</th>
                <th class="px-4 py-2 text-left">Email</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Segment</th>
                <th class="px-4 py-2 text-right">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($clients as $client)
                <tr class="border-b border-slate-100 hover:bg-slate-50">
                    <td class="px-4 py-2">
                        <a href="{{ route('clients.show', $client) }}" class="text-sky-700 hover:underline">
                            {{ $client->name }}
                        </a>
                        @if ($client->code)
                            <div class="text-xs text-slate-400">
                                Code: {{ $client->code }}
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        {{ $client->company_name ?? '-' }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $client->email ?? '-' }}
                    </td>
                    <td class="px-4 py-2">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                            @if($client->status === 'active') bg-emerald-100 text-emerald-700
                            @elseif($client->status === 'prospect') bg-amber-100 text-amber-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst($client->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        {{ $client->segment ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-right space-x-1">
                        <a href="{{ route('clients.edit', $client) }}"
                            class="text-xs rounded-lg border border-slate-300 px-2 py-1 hover:bg-slate-100">
                            Edit
                        </a>

                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Delete this client?')"
                                    class="text-xs rounded-lg border border-red-300 px-2 py-1 text-red-700 hover:bg-red-50">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-slate-500">
                        No clients found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3 border-t border-slate-100">
            {{ $clients->links() }}
        </div>
    </div>
@endsection
