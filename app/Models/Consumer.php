<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consumer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'active',
        'status',
        'discount',
        'activity_name',
        'pec',
        'address',
        'vat',
        'type_agency',
        'owner_name',
        'owner_surname',
        'owner_cf',
        'owner_bd',
        'owner_cm',
        'owner_sex',
        'owner_phone',
        'menu',
        'services_type',
        'domain',
        'r_property',
        'r_style',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
