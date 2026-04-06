<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
        'timezone',
        'code',
        'platform',
        'trading_name',
        'phone',
        'billing_address',
        'billing_suburb',
        'billing_state',
        'billing_postcode',
        'delivery_address',
        'delivery_suburb',
        'delivery_state',
        'delivery_postcode',
        'website_url',
        'abn_acn',
        'plan',
        'storman_api_url',
        'storman_api_token',
        'user_id',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
