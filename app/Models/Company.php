<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    public function branches()
    {
        # code...
        return $this->hasMany('App\Models\Branch');
    }

    protected $casts = [
        'created_at' => 'datetime:d-M-y',
        'updated_at' => 'datetime:d-M-y'
    ];

}
