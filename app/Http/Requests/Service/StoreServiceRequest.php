<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'   => ['required', 'exists:clients,id'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date'  => ['nullable', 'date'],
            'due_date'    => ['nullable', 'date'],
            'priority'    => ['required', 'in:low,medium,high,critical'],
            'status'      => ['required', 'in:new,in_progress,on_hold,completed,cancelled'],
        ];
    }
}
