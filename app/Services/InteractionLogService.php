<?php

namespace App\Services;

use App\Models\InteractionLog;
use Illuminate\Support\Facades\Auth;

class InteractionLogService
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {}

    /**
     * Buat interaction log baru.
     */
    public function createLog(array $data): InteractionLog
    {
        // user_id bisa null kalau belum ada auth, nanti akan selalu terisi
        $data['user_id'] = Auth::id();

        $log = InteractionLog::create($data);

        $this->activityLogService->log(
            Auth::id(),
            $log,
            'created',
            'Interaction log created',
            [
                'attributes' => $log->toArray(),
            ]
        );

        return $log;
    }

    /**
     * Ambil log untuk 1 client (opsional, kalau mau dipakai terpisah).
     */
    public function getLogsForClient(int $clientId, int $limit = 10)
    {
        return InteractionLog::where('client_id', $clientId)
            ->latest()
            ->limit($limit)
            ->get();
    }
}
