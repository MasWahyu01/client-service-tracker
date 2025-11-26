<?php

namespace App\Services;

use App\Models\InteractionLog;

class InteractionLogService
{
    public function createLog(array $data): InteractionLog
    {
        $data['user_id'] = auth()->id(); // null kalau belum login

        return InteractionLog::create($data);
    }

    public function getLogsForClient(int $clientId, int $limit = 10)
    {
        return InteractionLog::where('client_id', $clientId)
            ->latest()
            ->limit($limit)
            ->get();
    }
}
