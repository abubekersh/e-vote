<?php

namespace App\Http\Controllers;

use App\Models\TokenRegenerationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\voter;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class VoterController extends Controller
{
    private $adminLinks  = ['manage-users', 'compliants', 'token-regeneration', 'generate-report'];
    public function newToken()
    {
        return view('admin.new-token', ['user' => Auth::user(), 'db' => $this->adminLinks, 'token_requests' => TokenRegenerationRequest::where('status', '=', 'pending')->orderByDesc('created_at')->paginate(2)]);
    }
    public function login()
    {
        return view('voter.login');
    }
    public function checkLogin(Request $request)
    {
        $voter = $request->validate([
            'email' => 'required|email|exists:voters,email',
            'token' => 'required'
        ]);
        if (voter::where('email', '=', $voter['email'])->get()[0]->token !== $voter['token']) {
            return back()->withErrors([
                'token' => 'email and the provided token does not much'
            ]);
        }
        $v = voter::where('token', $voter['token'])->firstOrFail();
        if ($v->token_expires_at < now()) {
            return back()->with('success', 'you have already voted');
        }
        $link = URL::temporarySignedRoute('voter.vote', now()->addMinutes(15), ['token' => $voter['token']]);
        try {

            Mail::raw("Hello voter, This is the voting link click and vote with it within 15 minutes: $link", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Your secure voting link');
            });
        } catch (Exception $e) {
            return back()->withErrors('email', 'connection could not be established');
        }
        // session()->flash('success','the voting link will be sent to you via email');
        return back()->with('success', 'the voting link will be sent to you via email');
    }
    public function autoLogin(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $voter = Voter::where('token', $request->token)->first();

        if (!$voter) {
            return response()->json(['error' => 'Token not found.'], 404);
        }

        if ($voter->token_expires_at < now()) {
            return response()->json(['error' => 'You have already voted.'], 403);
        }

        $link = URL::temporarySignedRoute('voter.vote', now()->addMinutes(15), ['token' => $request->token]);

        try {
            Mail::raw("Hello voter, This is your voting link: $link", function ($message) use ($voter) {
                $message->to($voter->email)->subject('Your secure voting link');
            });
        } catch (Exception $e) {
            return response()->json(['error' => 'Email could not be sent.'], 500);
        }

        return response()->json(['success' => true, 'message' => 'Voting link sent to your email.']);
    }

    public function verifyLink(Request $request, $token)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Link has expired or is invalid.');
        }

        $voter = Voter::where('token', $token)->first();

        if (!$voter || $voter->token_expires_at < now()) {
            abort(403, 'Invalid or expired voting access.');
        }

        // Redirect to voting page
        return redirect()->route('vote.page', ['token' => $token]);
    }
    public function lostToken()
    {
        return view('voter.lost-token');
    }
    public function sendTokenRequest(Request $request)
    {
        $tre = $request->validate([
            'email' => 'required',
            'name' => 'required',
            'date_of_birth' => 'required',
            'id_photo' => 'required|file|mimes:jpg|max:2048'
        ]);
        if (!voter::where('email', '=', $tre['email'])->exists()) {
            $tre['status'] = "rejected";
            session()->flash('sucess', 'request automatically rejected! try sometime later or visit the polling station');
        } else {
            $tre['id_photo'] = $request->file('id_photo')->store('id_photos', 'public');
            $tre['voter_id'] = voter::where('email', '=', $tre['email'])->get()[0]->id;
            $tre['status'] = 'pending';
            unset($tre['email']);
            TokenRegenerationRequest::create($tre);
            session()->flash('success', 'request have been sent!email will be sent after check');
        }
        return redirect('/vote/lost-token');
    }
}
