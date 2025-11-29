<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'description',
        'start_date',
        'due_date',
        'priority',
        'status',
        'pic_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // PIC is a user (optional)
    public function pic()
    {
        return $this->belongsTo(\App\Models\User::class, 'pic_id');
    }
}
