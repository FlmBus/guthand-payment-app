<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const UPDATED_AT = null;
    
    protected $dates = [
        'created_at',
    ];

    protected $fillable = [
        'from',
        'to',
        'amount',
    ];
}
