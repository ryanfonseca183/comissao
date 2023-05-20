<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guard = [];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function indication()
    {
        return $this->belongsTo(Company::class, 'id');
    }
}
