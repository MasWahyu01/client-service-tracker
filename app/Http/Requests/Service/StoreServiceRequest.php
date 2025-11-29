<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        // akses sudah dikontrol via middleware role, jadi ijinkan
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'   => ['required', 'exists:clients,id'],
            'name'        => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'start_date'  => ['nullable', 'date'],
            'due_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'priority'    => ['required', 'in:low,medium,high'],
            'status'      => ['required', 'in:new,in_progress,on_hold,completed,cancelled'],
            'pic_id'      => ['nullable', 'exists:users,id'], // jika PIC merujuk ke users
        ];
    }
}
