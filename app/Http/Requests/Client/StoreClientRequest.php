<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Nanti akan kita ganti pakai policy/RBAC.
        return true;
    }

    public function rules(): array
    {
        return [
            'code'         => ['nullable', 'string', 'max:50', 'unique:clients,code'],
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
