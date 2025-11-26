@extends('layouts.app')

@section('title', 'Edit Client')
@section('page_label', 'Client Management')
@section('page_title', 'Edit Client')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 max-w-3xl">
    <form action="{{ route('clients.update', $client) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-2 gap-4">
            {{-- Client Name --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">Client Name *</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $client->name) }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                        focus:ring-2 focus:ring-sky-500 focus:outline-none"
                >
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Code --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">Code (optional)</label>
                <input
                    type="text"
                    name="code"
                    value="{{ old('code', $client->code) }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                        focus:ring-2 focus:ring-sky-500 focus:outline-none"
                >
                @error('code')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $client->email) }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                        focus:ring-2 focus:ring-sky-500 focus:outline-none"
                >
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">Phone</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $client->phone) }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                        focus:ring-2 focus:ring-sky-500 focus:outline-none"
                >
                @error('phone')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            {{-- Company Name --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">Company Name</label>
                <input
                    type="text"
                    name="company_name"
                    value="{{ old('company_name', $client->company_name) }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                        focus:ring-2 focus:ring-sky-500 focus:outline-none"
                >
                @error('company_name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Industry --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">Industry</label>
                <input
                    type="text"
                    name="industry"
                    value="{{ old('industry', $client->industry) }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                        focus:ring-2 focus:ring-sky-500 focus:outline-none"
                >
                @error('industry')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Address --}}
        <div>
            <label class="block text-sm font-medium text-slate-700">Address</label>
            <textarea
                name="address"
                rows="2"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                    focus:ring-2 focus:ring-sky-500 focus:outline-none"
            >{{ old('address', $client->address) }}</textarea>
            @error('address')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            {{-- City --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">City</label>
                <input
                    type="text"
                    name="city"
                    value="{{ old('city', $client->city) }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                        focus:ring-2 focus:ring-sky-500 focus:outline-none"
                >
                @error('city')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Country --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">Country</label>
                <input
                    type="text"
                    name="country"
                    value="{{ old('country', $client->country) }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                        focus:ring-2 focus:ring-sky-500 focus:outline-none"
                >
                @error('country')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">Status *</label>
                <select
                    name="status"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                        focus:ring-2 focus:ring-sky-500 focus:outline-none"
                >
                    <option value="prospect" @selected(old('status', $client->status) === 'prospect')>Prospect</option>
                    <option value="active" @selected(old('status', $client->status) === 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $client->status) === 'inactive')>Inactive</option>
                </select>
                @error('status')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            {{-- Segment --}}
            <div>
                <label class="block text-sm font-medium text-slate-700">Segment (VIP, SME, etc.)</label>
                <input
                    type="text"
                    name="segment"
                    value="{{ old('segment', $client->segment) }}"
                    class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                            focus:ring-2 focus:ring-sky-500 focus:outline-none"
                >
                @error('segment')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Notes --}}
        <div>
            <label class="block text-sm font-medium text-slate-700">Notes</label>
            <textarea
                name="notes"
                rows="3"
                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                        focus:ring-2 focus:ring-sky-500 focus:outline-none"
            >{{ old('notes', $client->notes) }}</textarea>
            @error('notes')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2 pt-4">
            <a href="{{ route('clients.show', $client) }}"
                class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                Cancel
            </a>
            <button type="submit"
                    class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                Update Client
            </button>
        </div>
    </form>
</div>
@endsection
