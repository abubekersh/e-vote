<?php

namespace App\Http\Controllers;

use App\Models\candidate;
use App\Models\politicalParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    public function create()
    {
        $con = Auth::user()->election_admin->constituency_id;
        $candidates = Candidate::where('constituency_id', $con)->get();
        return view('election-admin.create', ['user' => Auth::user(), 'links' => ['candidates'], 'candidates' => $candidates]);
    }
    public function store(Request $request)
    {
        try {
            $type = $request->type;
            $rule = [
                'name' => 'required|max:32',
                'type' => 'required',
                'picture' => 'required|file|mimes:jpg|max:2048'
            ];
            if ($type == "individual") {
                $rule['symbol'] = ['required', 'file', 'mimes:png,svg', 'max:2048'];
                $path = $request->file('symbol')->store('electionSymbols', 'public');
            }
            if ($type == "party") {
                $rule['party'] = ['required', 'exists:political_parties,name'];
            }
            $user = $request->validate($rule);

            $pic = $request->file('picture')->store('candidatePictures', 'public');
            if ($type == "individual") {
                $c = candidate::create([
                    'name' => $user['name'],
                    'constituency_id' => Auth::user()->election_admin->constituency_id,
                    'type' => 'individual',
                    'picture' => $pic,
                    'symbol' => $path,
                ]);
                // dd($pic, $path);
            }
            if ($type == "party") {
                $c = candidate::create([
                    'name' => $user['name'],
                    'constituency_id' => Auth::user()->election_admin->constituency_id,
                    'political_party_id' => politicalParty::where('name', '=', $user['party'])->firstOrFail()->id,
                    'type' => 'party',
                    'picture' => $pic
                ]);
            }
            session()->flash('success', 'User successfully created');
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect(route('candidates'));
    }
    public function stats()
    {
        $con = Auth::user()->election_admin->constituency_id;
        $independentCount = Candidate::where('constituency_id', $con)->whereNull('political_party_id')->count();
        $partyAffiliatedCount = Candidate::where('constituency_id', $con)->whereNotNull('political_party_id')->count();

        $candidates = Candidate::where('constituency_id', $con)->get();

        return view('election-admin.stats', compact(
            'independentCount',
            'partyAffiliatedCount',
            'candidates'
        ));
    }
    public function destroy(Request $request)
    {
        candidate::destroy($request->id);
        return back()->with(['success' => 'candidate removed successfully']);
    }
}
