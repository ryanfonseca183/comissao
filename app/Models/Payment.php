<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public $timestamps = false;
    
    protected $casts = [
        'expiration_date' => 'date',
        'payment_date' => 'datetime',
    ];

    public function indication()
    {
        return $this->belongsTo(Company::class, 'indication_id');
    }

    public function getExpiredAttribute()
    {
        return $this->expiration_date->lessThan(now());
    }
}
