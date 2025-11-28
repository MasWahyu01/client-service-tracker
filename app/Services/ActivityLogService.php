<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    public function log(
        ?int $userId,
        Model $subject,
        string $action,
        ?string $description = null,
        array $properties = []
    ): ActivityLog {
        return ActivityLog::create([
            'user_id'      => $userId,
            'subject_type' => get_class($subject),
            'subject_id'   => $subject->getKey(),
            'action'       => $action,
            'description'  => $description,
            'properties'   => $properties ?: null,
        ]);
    }
}
