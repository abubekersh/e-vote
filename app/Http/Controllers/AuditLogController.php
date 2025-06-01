<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\models\User;

class AuditLogController extends Controller
{
    private $adminLinks  = ['manage-users', 'compliants', 'system-logs', 'token-regeneration', 'generate-report'];
    public function index()
    {
        return view('admin.system-logs', ['user' => Auth::user(), 'db' => $this->adminLinks, 'users' => User::orderByDesc('created_at')->paginate(4)]);
    }
}
