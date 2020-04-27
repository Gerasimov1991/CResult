<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //

    public function company()
    {
        # code...
        return $this->belongsTo('App\Models\Company');
    }

    protected $casts = [
        'created_at' => 'datetime:d-M-y',
        'updated_at' => 'datetime:d-M-y'
    ];
}
