<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public $timestamps = false;
    
    protected $casts = [
        'payment_date' => 'date',
    ];

    public function indication()
    {
        return $this->belongsTo(Company::class, 'indication_id');
    }
}
