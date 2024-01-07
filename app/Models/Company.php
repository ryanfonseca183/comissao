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

    public function statusEqualTo($name)
    {
        return $this->status == constant('App\Enums\IndicationStatusEnum::'.$name);
    }
    public function statusIn($names)
    {
        foreach ($names as $name) {
            if($this->statusEqualTo($name)) return true;
        }
        return false;
    }
    public function statusDiffFrom($name)
    {
        return $this->status != constant('App\Enums\IndicationStatusEnum::'.$name);
    }
    public function statusNotIn($names)
    {
        $bool = true;
        foreach ($names as $name) {
            $bool = $bool && $this->statusDiffFrom($name);
        }
        return $bool;
    }

    public function getCanBeUpdatedAttribute()
    {
        return $this->statusNotIn(['RECUSADO', 'RESCINDIDO']);
    }
}
