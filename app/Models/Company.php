<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function budget()
    {
        return $this->hasOne(Budget::class, 'company_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'indication_id');
    }
}
