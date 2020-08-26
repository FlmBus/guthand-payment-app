<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const UPDATED_AT = null;

    public $dates = [
        'created_at',
    ];

    protected $fillable = [
        'from',
        'to',
        'amount',
    ];

    public function from() {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function to() {
        return $this->belongsTo(User::class, 'to', 'id');
    }
}
