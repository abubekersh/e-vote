<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class candidate extends Model
{
    /** @use HasFactory<\Database\Factories\CandidateFactory> */
    use HasFactory;
    protected $fillable = ['name', 'constituency_id', 'type', 'symbol', 'picture', 'political_party_id'];

    public function constituency()
    {
        return $this->belongsTo(constituency::class);
    }
    public function politicalParty()
    {
        return $this->belongsTo(politicalParty::class);
    }
}
