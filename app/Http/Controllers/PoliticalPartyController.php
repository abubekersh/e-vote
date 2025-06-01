<?php

namespace App\Http\Controllers;

use App\Models\politicalParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PoliticalPartyController extends Controller
{
    public function create()
    {
        return view('managment.parties', ['user' => Auth::user(), 'links' => ['timeline', 'polling-station', 'constituency', 'political-parties'], 'parties' => politicalParty::all()]);
    }
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'symbol' => 'required|file|mimes:png,svg|max:2048',
        ]);
        $path = $request->file('symbol')->store('electionSymbols', 'public');
        try {
            DB::table('political_parties')->updateOrInsert(
                ['name' => $validator['name']],
                ['symbol' => $path]
            );
            return back()->with('success', ' political party inserted.');
        } catch (\Exception $e) {
            Log::error('Error inserting data ' . $e->getMessage());
            return back()->withErrors(['symbol' => 'Error while saving data.'])->withInput();
        }
    }
    public function destroy(Request $request)
    {
        politicalParty::destroy($request->id);
        return back()->with(['success' => 'party removed successfully']);
    }
}
