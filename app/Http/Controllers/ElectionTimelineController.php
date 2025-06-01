<?php

namespace App\Http\Controllers;

use App\Models\electionTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\constituency;
use App\Models\politicalParty;
use App\Models\pollingStation;

class ElectionTimelineController extends Controller
{
    public function create(Request $request)
    {
        return view('managment.timeline', ['user' => Auth::user(), 'links' => ['timeline', 'polling-station', 'constituency', 'political-parties'], 'timelines' => electionTimeline::all()]);
    }
    public function store(Request $request)
    {
        $timeline = $request->validate([
            'timeline' => 'required',
            'startdate' => 'required|date',
            'starttime' => 'required',
            'enddate' => 'required',
            'endtime' => 'required'
        ]);
        $db = electionTimeline::UpdateOrcreate(
            ['type' => $timeline['timeline']],
            [
                'starts' => $timeline['startdate'] . " " . $timeline['starttime'],
                'ends' => $timeline['enddate'] . " " . $timeline['endtime']
            ]
        );
        return redirect()->back();
    }
    public function managmentStats()
    {
        $totalSchedules = electionTimeline::count();
        $totalPollingStations = PollingStation::count();
        $totalConstituencies = Constituency::count();
        $totalPoliticalParties = PoliticalParty::count();

        $recentSchedules = electionTimeline::latest()->take(5)->get();
        $recentPollingStations = PollingStation::latest()->take(5)->get();
        $recentConstituencies = Constituency::latest()->take(5)->get();
        $recentPoliticalParties = PoliticalParty::latest()->take(5)->get();
        $links = ['timeline', 'polling-station', 'constituency', 'political-parties'];
        return view("managment.stats", compact(
            'totalSchedules',
            'totalPollingStations',
            'totalConstituencies',
            'totalPoliticalParties',
            'recentSchedules',
            'recentPollingStations',
            'recentConstituencies',
            'recentPoliticalParties',
            'links'
        ));
    }
}
