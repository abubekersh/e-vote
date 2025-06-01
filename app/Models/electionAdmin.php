<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class electionAdmin extends Model
{
    /** @use HasFactory<\Database\Factories\ElectionAdminFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'constituency_id'];
    public function constituency()
    {
        return $this->belongsTo(constituency::class);
    }
    public function set_constituency($id)
    {
        $this->update([
            'constituency_id' => $id
        ]);
    }
}
