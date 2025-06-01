<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voter extends Model
{
    /** @use HasFactory<\Database\Factories\VoterFactory> */
    use HasFactory;
    protected $fillable = ['token', 'token_expires_at'];

    public function polling_station()
    {
        return $this->belongsTo(pollingStation::class);
    }
    public function token_request()
    {
        return $this->hasOne(TokenRegenerationRequest::class);
    }
    public function address()
    {
        return $this->belongsTo(address::class);
    }
}
