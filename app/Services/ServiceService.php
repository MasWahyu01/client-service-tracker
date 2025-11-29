<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ServiceService
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {}

    /**
     * Pagination + filtering services.
     */
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

    /**
     * Create service baru.
     */
    public function createService(array $data): Service
    {
        // Pastikan pic_id empty string -> null
        if (isset($data['pic_id']) && $data['pic_id'] === '') {
            $data['pic_id'] = null;
        }

        $service = Service::create($data);

        $this->activityLogService->log(
            Auth::id(),
            $service,
            'created',
            'Service created',
            [
                'attributes' => $service->toArray(),
            ]
        );

        return $service;
    }


    /**
     * Update data service (bukan status cepat).
     */
    public function updateService(Service $service, array $data): Service
    {
        $original = $service->getOriginal();

        $service->update($data);

        $changes = $service->getChanges();

        $this->activityLogService->log(
            Auth::id(),
            $service,
            'updated',
            'Service updated',
            [
                'before'  => $original,
                'after'   => $service->toArray(),
                'changes' => $changes,
            ]
        );

        return $service;
    }

    /**
     * Hapus service.
     */
    public function deleteService(Service $service): void
    {
        $snapshot = $service->toArray();

        $service->delete();

        $this->activityLogService->log(
            Auth::id(),
            $service,
            'deleted',
            'Service deleted',
            [
                'attributes' => $snapshot,
            ]
        );
    }

    /**
     * Update status cepat (dipakai dari dropdown AJAX).
     */
    public function updateStatus(Service $service, string $status): Service
    {
        $oldStatus = $service->status;

        $service->status = $status;
        $service->save();

        $this->activityLogService->log(
            Auth::id(),
            $service,
            'status_changed',
            'Service status changed',
            [
                'old_status' => $oldStatus,
                'new_status' => $status,
            ]
        );

        return $service;
    }
}
