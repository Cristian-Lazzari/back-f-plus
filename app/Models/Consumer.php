<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consumer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id', 'active', 'status', 'type_agency', 'pec', 'address', 'vat', 'name', 'surname', 'birth_date', 'cf', 'phone', 'menu', 'domain', 'r_property', 'opening_times', 'services_times'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
