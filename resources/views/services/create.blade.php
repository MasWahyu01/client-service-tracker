@extends('layouts.app')

@section('title', 'Create Service')
@section('page_label', 'Service Management')
@section('page_title', 'Create Service')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-800">Create Service</h3>
        <a href="{{ route('services.index') }}"
            class="text-sm rounded-lg border px-3 py-1 hover:bg-slate-50">Back to list</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 text-red-700 px-4 py-2 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('services.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Client select (jika datang dari client detail, $clientId dikirim) --}}
        <div>
            <label class="text-xs font-medium text-slate-700">Client *</label>
            <select name="client_id" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @if(isset($clientId) && $clientId)
                    {{-- Preselect single client --}}
                    @php
                        $client = \App\Models\Client::find($clientId);
                    @endphp
                    @if($client)
                        <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->company_name ?? '-' }})</option>
                    @endif
                @else
                    <option value="">-- Select client --</option>
                    @foreach(\App\Models\Client::orderBy('name')->get() as $c)
                        <option value="{{ $c->id }}" @selected(old('client_id') == $c->id)>{{ $c->name }} {{ $c->company_name ? "({$c->company_name})" : '' }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-slate-700">Service Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            </div>

            <div>
                <label class="text-xs font-medium text-slate-700">Priority *</label>
                <select name="priority" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    <option value="low" @selected(old('priority')=='low')>Low</option>
                    <option value="medium" @selected(old('priority')=='medium')>Medium</option>
                    <option value="high" @selected(old('priority')=='high')>High</option>
                </select>
            </div>
        </div>

        <div>
            <label class="text-xs font-medium text-slate-700">Description</label>
            <textarea name="description" rows="4" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('description') }}</textarea>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="text-xs font-medium text-slate-700">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="text-xs font-medium text-slate-700">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>
        </div>

        <div>
            <label class="text-xs font-medium text-slate-700">Assign PIC (optional)</label>
            <select name="pic_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                <option value="">-- Not assigned --</option>
                @foreach(\App\Models\User::orderBy('name')->get() as $u)
                    <option value="{{ $u->id }}" @selected(old('pic_id') == $u->id)>{{ $u->name }} ({{ $u->role }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-xs font-medium text-slate-700">Status *</label>
            <select name="status" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                <option value="new" @selected(old('status')=='new')>New</option>
                <option value="in_progress" @selected(old('status')=='in_progress')>In Progress</option>
                <option value="on_hold" @selected(old('status')=='on_hold')>On Hold</option>
                <option value="completed" @selected(old('status')=='completed')>Completed</option>
                <option value="cancelled" @selected(old('status')=='cancelled')>Cancelled</option>
            </select>
        </div>

        <div class="text-right">
            <button type="submit" class="rounded-lg bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">
                Create Service
            </button>
        </div>
    </form>
</div>
@endsection
