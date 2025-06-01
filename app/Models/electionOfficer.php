<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class electionOfficer extends Model
{
    /** @use HasFactory<\Database\Factories\ElectionOfficerFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'polling_station_id'];

    public function polling_station()
    {
        return $this->belongsTo(pollingStation::class);
    }
    public function set_polling_station($id)
    {
        $this->update([
            'polling_station_id' => $id
        ]);
    }
}
