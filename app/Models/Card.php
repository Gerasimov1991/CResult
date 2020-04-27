<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //
    protected $guarded = [];
    public function branch()
    {
        # code...
        return $this->belongsTo('App\Models\Branch');
    }
    public function package()
    {
        # code...
        return $this->belongsTo('App\Models\Package');
    }
    protected $casts = [
        'created_at' => 'datetime:d-M-y',
        'updated_at' => 'datetime:d-M-y'
    ];
}
