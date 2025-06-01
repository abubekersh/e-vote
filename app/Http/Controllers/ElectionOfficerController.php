<?php

namespace App\Http\Controllers;

use App\Models\address;
use App\Models\pollingStation;
use App\Models\vote;
use App\Models\voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ElectionOfficerController extends Controller
{

    public function generateToken(Voter $voter)
    {
        do {
            $token = Str::upper(Str::random(15));
        } while (voter::where('token', '=', $token)->exists());
        $expiresAt = Carbon::now()->addDays(7);
        $voter->update([
            'token' => $token,
            'token_expires_at' => $expiresAt,
        ]);
        return $token;
    }
    public function create()
    {
        return view('election-officer.create', ['user' => Auth::user(), 'links' => ['create-voter']]);
    }
    public function store(Request $request)
    {
        $voterval = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:voters,email',
            'gender' => 'required',
            'dob' => ['required', Rule::date()->before('2007-09-02')],
            'disability' => 'required',
            'region' => 'required',
            'zone' => 'required',
            'woreda' => 'required',
            'kebele' => 'required',
            'housenumber' => 'required',
            'duration' => 'required|integer',
            'kebeleid' => 'required|file|mimes:jpg|max:2048'
        ]);
        if (voter::where('name', $voterval['name'])->exists()) {
            if (voter::where('name', $voterval['name'])->firstOrFail()->address->kebele == $voterval['kebele']) {
                return back()->withErrors(['name' => 'the voter is already registered']);
            }
        }
        $address = address::create([
            'region' => $voterval['region'],
            'zone' => $voterval['zone'],
            'woreda' => $voterval['woreda'],
            'kebele' => $voterval['kebele'],
            'house_number' => $voterval['housenumber']
        ]);
        $path = $request->file('kebeleid')->store('kebeleIds', 'public');
        $voter = new voter;
        $voter->name = $voterval['name'];
        $voter->email = $voterval['email'];
        $voter->polling_station_id = Auth::user()->election_officer->polling_station_id;
        $voter->token = "";
        $voter->name = $voterval['name'];
        $voter->gender = $voterval['gender'];
        $voter->date_of_birth = $voterval['dob'];
        $voter->disability = $voterval['disability'];
        $voter->residency_duration = $voterval['duration'];
        $voter->address_id = $address->id;
        $voter->kebele_id = $path;
        $voter->save();
        $this->generateToken($voter);
        session()->flash('success', 'Voter successfully created');
        return redirect(route('voter-card', ['voter' => $voter->id]));
    }
    public function stats()
    {
        $station = PollingStation::with('voters')->findOrFail(Auth::user()->election_officer->polling_station_id);

        $voterTokens = $station->voters->pluck('token'); // Get all real tokens
        $hashedTokens = $voterTokens->map(function ($token) {
            return hash('sha256', $token);
        });

        // Get votes with hashed_tokens matching any voter's hashed token
        $votedCount = vote::whereIn('hashed_token', $hashedTokens)->count();
        $total = $voterTokens->count();
        $notVotedCount = $total - $votedCount;

        return view('election-officer.stats', [
            'station' => $station,
            'total' => $total,
            'voted' => $votedCount,
            'notVoted' => $notVotedCount,
        ]);
    }
}
