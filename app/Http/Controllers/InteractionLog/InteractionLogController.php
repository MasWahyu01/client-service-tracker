<?php

namespace App\Http\Controllers\InteractionLog;

use App\Http\Controllers\Controller;
use App\Http\Requests\InteractionLog\StoreInteractionLogRequest;
use App\Services\InteractionLogService;

class InteractionLogController extends Controller
{
    public function __construct(
        protected InteractionLogService $interactionLogService
    ) {}

    public function store(StoreInteractionLogRequest $request)
    {
        $log = $this->interactionLogService->createLog($request->validated());

        return redirect()
            ->route('clients.show', $log->client_id)
            ->with('success', 'Interaction log added successfully.');
    }
}
