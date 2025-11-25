<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'company_name',
        'industry',
        'address',
        'city',
        'country',
        'status',
        'segment',
        'notes',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * One Client has many Services
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * One Client has many Interaction Logs
     */
    public function interactionLogs()
    {
        return $this->hasMany(InteractionLog::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (Reusable query logic)
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeProspect($query)
    {
        return $query->where('status', 'prospect');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
