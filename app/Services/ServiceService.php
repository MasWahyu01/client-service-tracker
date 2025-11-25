<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ServiceService
{
    public function paginateServices(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Service::with('client');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        return $query->latest()->paginate($perPage)->appends($filters);
    }

    public function createService(array $data): Service
    {
        return Service::create($data);
    }

    public function updateService(Service $service, array $data): Service
    {
        $service->update($data);
        return $service;
    }

    public function deleteService(Service $service): void
    {
        $service->delete();
    }
}
