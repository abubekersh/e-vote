<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ElectionResultController extends Controller
{
    public function index()
    {
        // A. Basic constituency stats
        $constituencyStats = DB::select("
        SELECT
            c.id AS constituency_id,
            c.name AS constituency_name,
            c.region,
            COUNT(DISTINCT v.id) AS registered_voters,
            COUNT(DISTINCT vt.hashed_token) AS votes_cast
        FROM constituencies c
        LEFT JOIN polling_stations ps ON ps.constituency_id = c.id
        LEFT JOIN voters v ON v.polling_station_id = ps.id
        LEFT JOIN votes vt ON SHA2(v.token, 256) = vt.hashed_token
        GROUP BY c.id, c.name, c.region
    ");

        // B. Candidate vote count
        $candidateVotes = DB::select("
        SELECT
            ca.constituency_id,
            ca.id AS candidate_id,
            ca.name AS candidate_name,
            COUNT(vt.id) AS votes_received
        FROM candidates ca
        LEFT JOIN votes vt ON vt.candidate_id = ca.id
        GROUP BY ca.constituency_id, ca.id, ca.name
    ");

        // C. Group candidate votes by constituency_id
        $groupedCandidates = [];
        foreach ($candidateVotes as $row) {
            $groupedCandidates[$row->constituency_id][] = $row;
        }

        // D. Inject candidates into each constituencyStat
        foreach ($constituencyStats as $stat) {
            $stat->candidates = $groupedCandidates[$stat->constituency_id] ?? [];

            // Optional: calculate turnout for Blade
            $stat->turnout_percentage = $stat->registered_voters > 0
                ? round(($stat->votes_cast / $stat->registered_voters) * 100, 2)
                : 0;
        }

        return view('results.index', compact('constituencyStats'));
    }
}
