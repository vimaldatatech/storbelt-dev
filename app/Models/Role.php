<?php

namespace App\Models;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'guard_name',
        'company_user_id',
    ];

    protected $casts = [
        'company_user_id' => 'integer',
    ];
}
