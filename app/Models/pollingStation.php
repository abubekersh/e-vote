<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pollingStation extends Model
{
    /** @use HasFactory<\Database\Factories\PollingStationFactory> */
    use HasFactory;
    public function constituency()
    {
        return $this->belongsTo(constituency::class);
    }
    public function voters()
    {
        return $this->hasMany(voter::class);
    }
}
