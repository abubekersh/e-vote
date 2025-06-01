<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    /** @use HasFactory<\Database\Factories\ComplientFactory> */
    use HasFactory;
    protected $fillable = ['email', 'type', 'description'];
}
