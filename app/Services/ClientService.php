<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ClientService
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {}

    /**
     * Pagination + filtering clients.
     */
    public function paginateClients(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Client::query();

        // Search by keyword (name / email / company)
        if (!empty($filters['q'])) {
            $keyword = $filters['q'];

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('company_name', 'like', "%{$keyword}%");
            });
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by segment/tag utama (VIP, SME, etc.)
        if (!empty($filters['segment'])) {
            $query->where('segment', $filters['segment']);
        }

        return $query->orderBy('name')
            ->paginate($perPage)
            ->appends($filters);
    }

    /**
     * Create client baru.
     */
    public function createClient(array $data): Client
    {
        $client = Client::create($data);

        $this->activityLogService->log(
            Auth::id(),
            $client,
            'created',
            'Client created',
            [
                'attributes' => $client->toArray(),
            ]
        );

        return $client;
    }

    /**
     * Update client.
     */
    public function updateClient(Client $client, array $data): Client
    {
        $original = $client->getOriginal();

        $client->update($data);

        $changes = $client->getChanges();

        $this->activityLogService->log(
            Auth::id(),
            $client,
            'updated',
            'Client updated',
            [
                'before'   => $original,
                'after'    => $client->toArray(),
                'changes'  => $changes,
            ]
        );

        return $client;
    }

    /**
     * Hapus client.
     */
    public function deleteClient(Client $client): void
    {
        $snapshot = $client->toArray();

        $client->delete();

        $this->activityLogService->log(
            Auth::id(),
            $client,
            'deleted',
            'Client deleted',
            [
                'attributes' => $snapshot,
            ]
        );
    }
}
