<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
