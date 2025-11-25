@extends('layouts.app')

@section('title', 'Add Service')
@section('page_label', 'Service Management')
@section('page_title', 'Add Service')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 max-w-3xl">
    <form action="{{ route('services.store') }}" method="POST" class="space-y-4">
        @csrf

        <input type="hidden" name="client_id" value="{{ $clientId }}">

        <div>
            <label class="block text-sm font-medium">Service Name *</label>
            <input type="text" name="name" class="mt-1 w-full rounded-lg border px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea name="description" rows="3" class="mt-1 w-full rounded-lg border px-3 py-2"></textarea>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label>Start Date</label>
                <input type="date" name="start_date" class="mt-1 w-full rounded-lg border px-3 py-2">
            </div>
            <div>
                <label>Due Date</label>
                <input type="date" name="due_date" class="mt-1 w-full rounded-lg border px-3 py-2">
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label>Priority</label>
                <select name="priority" class="mt-1 w-full rounded-lg border px-3 py-2">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>
            </div>

            <div>
                <label>Status</label>
                <select name="status" class="mt-1 w-full rounded-lg border px-3 py-2">
                    <option value="new">New</option>
                    <option value="in_progress">In Progress</option>
                    <option value="on_hold">On Hold</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-4">
            <a href="{{ route('clients.show', $clientId) }}"
                class="rounded-lg border px-4 py-2">
                Cancel
            </a>
            <button type="submit"
                    class="rounded-lg bg-sky-600 px-4 py-2 text-white">
                Save Service
            </button>
        </div>
    </form>
</div>
@endsection
