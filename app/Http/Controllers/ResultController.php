<?php

namespace App\Http\Controllers;

use App\Models\electionTimeline;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        return view('results.timeline', ['timelines' => electionTimeline::all()]);
    }
}
