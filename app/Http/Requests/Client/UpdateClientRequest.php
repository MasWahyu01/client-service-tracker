<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client')?->id ?? $this->route('client');

        return [
            'code'         => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('clients', 'code')->ignore($clientId),
            ],
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['nullable', 'email', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:50'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'industry'     => ['nullable', 'string', 'max:255'],
            'address'      => ['nullable', 'string', 'max:500'],
            'city'         => ['nullable', 'string', 'max:255'],
            'country'      => ['nullable', 'string', 'max:255'],
            'status'       => ['required', 'in:prospect,active,inactive'],
            'segment'      => ['nullable', 'string', 'max:100'],
            'notes'        => ['nullable', 'string'],
        ];
    }
}
