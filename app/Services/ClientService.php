<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClientService
{
    /**
     * Ambil list client dengan pagination + simple filter.
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

        return $query->orderBy('name')->paginate($perPage)
                     ->appends($filters);
    }

    /**
     * Create client baru.
     */
    public function createClient(array $data): Client
    {
        return Client::create($data);
    }

    /**
     * Update client.
     */
    public function updateClient(Client $client, array $data): Client
    {
        $client->update($data);

        return $client;
    }

    /**
     * Hapus client.
     */
    public function deleteClient(Client $client): void
    {
        $client->delete();
    }
}
