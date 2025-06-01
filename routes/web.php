<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ConstituencyController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ElectionOfficerController;
use App\Http\Controllers\ElectionResultController;
use App\Http\Controllers\ElectionTimelineController;
use App\Http\Controllers\PoliticalPartyController;
use App\Http\Controllers\PollingStationController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\User;
use App\Http\Controllers\VoterController;
use App\Http\Livewire\VoteCasting;
use App\Models\candidate;
use App\Models\Complaints;
use App\Models\electionOfficer;
use App\Models\politicalParty;
use App\Models\TokenRegenerationRequest;
use App\Models\vote;
use App\Models\voter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;

use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Color\Color;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Illuminate\Http\Request;
use App\Models\User as ModelsUser;

Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/results', [ElectionResultController::class, 'index'])->name('results.index');
Route::get('/constituencies', [ConstituencyController::class, 'index']);
//guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
    Route::get('/register', function () {
        return view('auth.register');
    });
    Route::get('/complaint', [ComplaintController::class, 'create'])->name('complaint');
    Route::post('/complaint', [ComplaintController::class, 'store']);
});
Route::post('/auto-login', [VoterController::class, 'autoLogin']);
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::get('/edit-profile', [User::class, 'editProfile'])->name('edit-profile');
    Route::post('/profile/edit/{usr}', [User::class, 'updateProfile']);
    Route::post('/profile/changep/{usr}', [User::class, 'changePassword']);
});


Route::get('/dashboard', function () {
    return redirect(
        '/' . Str::of(Auth::user()->role)->replace(' ', '')
    );
})->middleware('auth')->name('dashboard');

//Admin Routes
Route::prefix('/admin')->middleware('auth', 'role:admin')->group(function () {
    Route::get('', fn() => redirect('/admin/stats'));
    Route::get('stats', function () {
        $dbrole = App\Models\User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();
        $dbdate = App\Models\User::withTrashed()->select(DB::raw('DATE(created_at) as date,COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->limit(7)
            ->get();
        $st['users'] = \App\Models\User::all()->count();
        $st['deactiveated users'] = \App\Models\User::onlyTrashed()->count();
        $st['complaints'] = \App\Models\Complaints::all()->count();
        $st['logs'] = \App\Models\auditLog::all()->count() ?? 0;
        $date = $dbdate->pluck('count');
        $date_label = $dbdate->pluck('date');
        $label = $dbrole->pluck('role');
        $data = $dbrole->pluck('count');
        $user = Auth::user();
        $links = ['manage-users', 'compliants',  'token-regeneration', 'generate-report'];
        return view('admin.stats', compact('label', 'data', 'user', 'links', 'date', 'date_label', 'st'));
    });
    Route::get('manage-users', [User::class, 'ManageUsers'])->name('manage-users');
    Route::get('manage-users/create', [User::class, 'createUser'])->name('create-user');
    Route::post('manage-users/create', [User::class, 'storeUser'])->name('create-user');
    Route::get('manage-users/{id}/edit', [User::class, 'editUser']);
    Route::put('manage-users/update', [User::class, 'updateUser'])->name('update-user');
    Route::get('compliants', [ComplaintController::class, 'index'])->name('compliants');
    Route::get('token-regeneration', [VoterController::class, 'newToken'])->name('token-regeneration');
    Route::get('generate-report', function () {
        $totalUsers = ModelsUser::count();

        $users = ModelsUser::latest()->take(10)->get(); // recent 10 users

        $totalTokenRegenerations = TokenRegenerationRequest::count();
        $tokenRegenerations = TokenRegenerationRequest::latest()->take(10)->get(); // recent 10 token requests

        $totalComplaints = Complaints::count();
        $complaints = Complaints::latest()->take(10)->get();
        return view('admin.report', compact(
            'totalUsers',
            'users',
            'totalTokenRegenerations',
            'tokenRegenerations',
            'totalComplaints',
            'complaints'
        ));
    })->name('generate-report');
    Route::get('reports/download', function () {
        $totalUsers = ModelsUser::count();
        $users = ModelsUser::latest()->take(10)->get();

        $totalTokenRegenerations = TokenRegenerationRequest::count();
        $tokenRegenerations = TokenRegenerationRequest::latest()->take(10)->get();

        $totalComplaints = Complaints::count();
        $complaints = Complaints::latest()->take(10)->get();

        $pdf = PDF::loadView('admin.report-pdf', compact(
            'totalUsers',
            'users',
            'totalTokenRegenerations',
            'tokenRegenerations',
            'totalComplaints',
            'complaints'
        ));

        return $pdf->download('report_summary.pdf');
    });
});
Route::get('/search/all', [SearchController::class, 'search']);
Route::get('/search/c', [SearchController::class, 'searchc']);
Route::get('/search/ps', [SearchController::class, 'searchps']);
Route::get('/search/r', [SearchController::class, 'searchr']);
Route::get('/search/result', [SearchController::class, 'result']);
//Managment board member routes
Route::prefix('/managment')->middleware('auth', 'role:managment')->group(function () {
    Route::get('', fn() => redirect('/managment/stats'));
    Route::get('stats', [ElectionTimelineController::class, 'managmentStats']);
    Route::get('timeline', [ElectionTimelineController::class, 'create'])->name('timeline');
    Route::post('timeline', [ElectionTimelineController::class, 'store'])->name('timeline');
    Route::get('polling-station', [PollingStationController::class, 'create'])->name('polling-station');
    Route::post('polling-station', [PollingStationController::class, 'store'])->name('polling-station');
    Route::put('polling-station', [PollingStationController::class, 'update'])->name('polling-station');
    Route::get('constituency', [ConstituencyController::class, 'create'])->name('constituency');
    Route::post('constituency', [ConstituencyController::class, 'store'])->name('constituency');
    Route::put('constituency', [ConstituencyController::class, 'update'])->name('constituency');
    Route::get('political-parties', [PoliticalPartyController::class, 'create'])->name('political-parties');
    Route::post('political-parties', [PoliticalPartyController::class, 'store'])->name('political-parties');
    Route::delete('political-parties', [PoliticalPartyController::class, 'destroy']);
});
Route::prefix('/results')->group(function () {
    Route::get('/timeline', [ResultController::class, 'index'])->name('show-timeline');
});
Route::get('/card/{voter}', function (voter $voter) {
    $qrCode = new QrCode(
        data: $voter->token,
        encoding: new Encoding('UTF-8'),
        errorCorrectionLevel: ErrorCorrectionLevel::Medium,
        size: 300,
        margin: 10,
        roundBlockSizeMode: RoundBlockSizeMode::Margin,
        foregroundColor: new Color(0, 0, 0),
        backgroundColor: new Color(255, 255, 255)
    );

    // Use SVG writer
    $writer = new SvgWriter();
    $result = $writer->write($qrCode);

    // Get SVG output
    $svg = $result->getString();
    $path = "qr/qrcode.svg";
    Storage::disk('public')->put($path, $svg);
    // this is raw SVG code
    return view('election-officer.voter-card', ['voter' => $voter, 'qrcode' => $path]);
})->name('voter-card');
Route::get('/cardtopdf/{voter}', function (voter $voter) {
    $svgPath = 'qr/qrcode.svg';
    if (!Storage::disk('public')->exists($svgPath)) {
        abort(404, 'QR Code not found.');
    }
    $svgContent = Storage::disk('public')->get($svgPath);

    $encodedSvg = 'data:image/svg+xml;base64,' . base64_encode($svgContent);

    return Pdf::loadView('election-officer.voter-card', [
        'voter' => $voter,
        'qrcode' => $encodedSvg
    ])
        ->setPaper('a4')
        ->download("Voter_Token_{$voter->id}.pdf");
});
//Election Adminstrator routes
Route::prefix('/electionadmin')->middleware('auth', 'role:election admin')->group(function () {
    Route::get('', fn() => redirect('/electionadmin/stats'));
    Route::get('stats', [CandidateController::class, 'stats']);
    Route::get('candidates', [CandidateController::class, 'create'])->name('candidates');
    Route::post('candidates', [CandidateController::class, 'store'])->name('store-candidate');
    Route::delete('candidates', [CandidateController::class, 'destroy']);
});
Route::prefix('/electionofficer')->middleware('auth', 'role:election officer')->group(function () {
    Route::get('', fn() => redirect('/electionofficer/stats'));
    Route::get('stats', [ElectionOfficerController::class, 'stats']);
    Route::get('create-voter', [ElectionOfficerController::class, 'create'])->name('create-voter');
    Route::post('voter', [ElectionOfficerController::class, 'store'])->name('store-voter');
});
Route::prefix('/vote')->middleware('guest')->group(function () {
    Route::get('', [VoterController::class, 'login']);
    Route::post('', [VoterController::class, 'checkLogin']);
    Route::get('lost-token', [VoterController::class, 'lostToken']);
    Route::post('lost-token', [VoterController::class, 'sendTokenRequest']);
    Route::get('{token}', [VoterController::class, 'verifyLink'])->name('voter.vote');
    Route::get('cast/{token}', function ($token) {
        $constituency = voter::where('token', $token)->firstOrFail()->polling_station->constituency_id;
        $candidates = candidate::where('constituency_id', $constituency)->get();
        return view('voter.cast-vote', ['token' => $token, 'candidates' => $candidates]);
    })->name('vote.page')->middleware('valid');
    Route::post('submit', function (Request $request) {
        $request->validate([
            'token' => 'required|string',
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $voter = Voter::where('token', $request->token)
            ->where('token_expires_at', '>', now())
            ->firstOrFail();

        // Ensure one vote per voter
        if (Vote::where('hashed_token', hash('sha256', $voter->token))->exists()) {
            return back()->withErrors(['You have already voted.']);
        }

        // Get previous vote's hash (last entry in the table)
        $lastVote = Vote::latest()->first();
        $previousHash = $lastVote ? $lastVote->current_hash : null;

        // Hash the voter's token (anonymity)
        $hashedToken = hash('sha256', $voter->token);

        // Generate current hash (chaining)
        $dataToHash = $hashedToken . $request->candidate_id . $previousHash . now();
        $currentHash = hash('sha256', $dataToHash);

        // Save the vote
        vote::create([
            'hashed_token' => $hashedToken,
            'candidate_id' => $request->candidate_id,
            'previous_hash' => $previousHash,
            'current_hash' => $currentHash,
        ]);

        // Invalidate the token
        $voter->update([
            'token_expires_at' => now(),
        ]);

        return redirect('/thank-you')->with('message', 'Your vote has been recorded.');
    })->name('vote-submit');
});
Route::get('/thank-you', function () {
    return view('voter.thank-you');
});
Route::get('/c', function () {
    $data = App\Models\User::select('role', DB::raw('count(*) as count'))
        ->groupBy('role')
        ->get();
    $data = App\Models\User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get();
    $labels = $data->pluck('date');    // ['voter', 'admin', 'officer']
    $counts = $data->pluck('count');
    // Pass dates and counts to view
    // $labels = $userStats->pluck('date');
    // $data = $userStats->pluck('count');

    return view('livewire.counter', compact('labels', 'counts'));
    // return view('livewire.vote-stats');
    // $party = politicalParty::all();
    // return view('livewire.counter', ['party' => $party[3]]);
});

//password reset routes
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware(['guest', 'valid_token'])->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
