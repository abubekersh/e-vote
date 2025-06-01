<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenRegenerationRequest extends Model
{
    protected $fillable = ['email', 'name', 'date_of_birth', 'id_photo', 'voter_id'];

    public function voter()
    {
        return $this->belongsTo(voter::class);
    }
}
