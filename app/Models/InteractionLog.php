<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InteractionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'user_id',
        'type',
        'notes',
        'next_action',
        'next_action_due_at',
        'attachment_path',
    ];

    protected $casts = [
        'next_action_due_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getIsOverdueAttribute(): bool
    {
        return $this->next_action_due_at
            && $this->next_action_due_at < now();
    }
}
