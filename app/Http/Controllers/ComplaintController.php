<?php

namespace App\Http\Controllers;

use App\Models\Complaints;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    private $adminLinks  = ['manage-users', 'compliants',  'token-regeneration', 'generate-report'];
    public function index()
    {
        return view('admin.compliants', ['user' => Auth::user(), 'db' => $this->adminLinks, 'complaints' => Complaints::where('status', 'open')->orderByDesc('created_at')->paginate(10)]);
    }
    public function create()
    {
        return view('complaint');
    }
    public function store(Request $request)
    {
        $comp = $request->validate([
            'email' => 'required|email|exists:voters,email',
            'type' => 'required',
            'description' => 'required|string|max:300'
        ]);
        Complaints::create($comp);
        return back()->with('success', 'complaint send successfully');
    }
}
