<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentTypeEnum;

class Budget extends Model
{
    protected $guarded = [];

    protected $casts = [
        'first_payment_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }


    public function getTotalValueAttribute()
    {
        if($this->payment_type == PaymentTypeEnum::VIDA) {
            return $this->value * $this->employees_number;
        }
        if($this->payment_type == PaymentTypeEnum::METRO) {
            return $this->value * $this->measuring_area;
        }
        return $this->value;
    }
}
