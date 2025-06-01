<?php

namespace App\Http\Controllers;

use App\Models\candidate;
use App\Models\constituency;
use App\Models\politicalParty;
use App\Models\pollingStation;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        if (!$query) return response()->json([]);
        $c = constituency::where('name', 'like', "%$query%")
            ->limit(2)
            ->pluck('name');
        $p = politicalParty::where('name', 'like', "%$query%")
            ->limit(3)
            ->pluck('name');
        $ca = candidate::where('name', 'like', "%$query%")
            ->limit(3)
            ->pluck('name');
        $result = collect([$c, $p, $ca]);
        $resultc = $result->collapse();
        return response()->json($resultc);
    }
    public function searchc(Request $request)
    {
        $query = $request->input('query');
        if (!$query) return response()->json([]);
        $result = constituency::where('name', 'like', "%$query%")
            ->limit(3)
            ->pluck('name');
        return response()->json($result);
    }
    public function searchps(Request $request)
    {
        $query = $request->input('query');
        if (!$query) return response()->json([]);
        $result = pollingStation::where('name', 'like', "%$query%")
            ->limit(3)
            ->pluck('name');
        return response()->json($result);
    }
    public function result(Request $request)
    {
        $query = trim($request->input('q'));

        // Skip empty queries
        // if (strlen($query) < 2) {
        //     return view('results.search', ['query' => $query]);
        // }

        $candidates = Candidate::where('name', 'like', "%$query%")
            ->orWhere('symbol', 'like', "%$query%")
            ->with('politicalParty') // if exists
            ->get();

        $parties = PoliticalParty::where('name', 'like', "%$query%")

            ->get();

        $constituencies = Constituency::where('name', 'like', "%$query%")->get();

        return view('results.search', [
            'query' => $query,
            'candidates' => $candidates,
            'parties' => $parties,
            'constituencies' => $constituencies,
        ]);
    }
    public function searchr(Request $request)
    {
        $regions = ['tigiray', 'amhara', 'oromia', 'afar', 'benishangul gumuz', 'gambela', 'somali', 'harari', 'sidama', 'central ethiopia', 'south west ethiopia', 'south ethiopia'];
        $query = $request->input('query');
        if (!$query) return response()->json([]);
        $result = array_values(array_filter($regions, function ($item) use ($query) {
            return strpos($item, $query) !== false;
        }));
        return response()->json($result);
    }
}
