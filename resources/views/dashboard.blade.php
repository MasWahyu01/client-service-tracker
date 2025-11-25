@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_label', 'Overview')
@section('page_title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4">
        <div class="text-xs font-semibold text-slate-500 uppercase mb-1">
            Active Clients
        </div>
        <div class="text-3xl font-bold">
            0
        </div>
        <div class="text-xs text-slate-400 mt-1">
            Data dari database nanti.
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4">
        <div class="text-xs font-semibold text-slate-500 uppercase mb-1">
            Services In Progress
        </div>
        <div class="text-3xl font-bold">
            0
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4">
        <div class="text-xs font-semibold text-red-500 uppercase mb-1">
            Overdue Items
        </div>
        <div class="text-3xl font-bold text-red-600">
            0
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-4">
    <h2 class="text-base font-semibold mb-2">
        System Overview
    </h2>
    <p class="text-sm text-slate-600">
        Ini adalah dashboard awal. Nantinya akan ditambahkan grafik Chart.js,
        statistik layanan, reminder overdue, dan monitoring aktivitas real-time.
    </p>
</div>
@endsection
