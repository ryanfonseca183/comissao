<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public function indication()
    {
        return $this->belongsTo(Indication::class, 'company_id');
    }
}
