<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class electionTimeline extends Model
{
    /** @use HasFactory<\Database\Factories\ElectionTimelineFactory> */
    use HasFactory;
    protected $fillable = ['type', 'ends', 'starts'];
}
