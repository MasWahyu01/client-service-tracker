<?php

namespace App\Http\Requests\InteractionLog;

use Illuminate\Foundation\Http\FormRequest;

class StoreInteractionLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'           => ['required', 'exists:clients,id'],
            'type'                => ['required', 'in:call,email,meeting,chat,whatsapp'],
            'notes'               => ['required', 'string'],
            'next_action'         => ['nullable', 'string'],
            'next_action_due_at'  => ['nullable', 'date'],
        ];
    }
}
