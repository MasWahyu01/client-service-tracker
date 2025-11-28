@extends('layouts.app')

@section('title', 'Activity Logs')
@section('page_label', 'System Monitoring')
@section('page_title', 'Activity Logs')

@section('content')
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-4 py-2 text-left">Time</th>
                <th class="px-4 py-2 text-left">User</th>
                <th class="px-4 py-2 text-left">Action</th>
                <th class="px-4 py-2 text-left">Subject</th>
                <th class="px-4 py-2 text-left">Description</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($logs as $log)
                <tr class="border-b border-slate-100 hover:bg-slate-50">
                    <td class="px-4 py-2 text-xs text-slate-500">
                        {{ $log->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-4 py-2 text-xs text-slate-700">
                        {{ $log->user?->name ?? 'System / Unknown' }}
                    </td>
                    <td class="px-4 py-2 text-xs">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-medium bg-slate-100 text-slate-700">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-xs text-slate-700">
                        {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                    </td>
                    <td class="px-4 py-2 text-xs text-slate-600">
                        {{ $log->description ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-slate-500 text-sm">
                        No activity recorded yet.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
    </div>
@endsection
