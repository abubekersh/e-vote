<?php

namespace App\Http\Controllers;

use App\Mail\SendPassword;
use App\Models\constituency;
use App\Models\electionAdmin;
use App\Models\electionOfficer;
use App\Models\pollingStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\User as usr;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Livewire;

class User extends Controller
{
    private $adminLinks  = ['manage-users', 'compliants',  'token-regeneration', 'generate-report'];
    public function manageUsers(Request $request)
    {
        return view('admin.manage-users', ['user' => Auth::user(), 'db' => $this->adminLinks, 'users' => usr::withTrashed()->orderByDesc('created_at')->paginate(50)]);
    }
    public function createUser()
    {
        return view('admin.create', ['user' => Auth::user(), 'db' => $this->adminLinks]);
    }
    function storeUser(Request $request)
    {
        try {
            $role = $request->role;
            $rule = [
                'name' => 'required|max:32',
                'email' => 'required|email|unique:users,email',
                'password' => ['required', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
                'role' => 'required'
            ];
            if ($role == "election admin") {
                $rule['constituency'] = [Rule::requiredIf(fn() => $role == "election admin"), Rule::exists('constituencies', 'name')];
            }
            if ($role == "election officer") {
                $rule['polling_station'] = [Rule::requiredIf(fn() => $role == "election officer"), Rule::exists('polling_stations', 'name')];
            }
            $user = $request->validate($rule);
        } catch (\Throwable $th) {
            throw $th;
        }
        $u = usr::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'],
            'role' => $user['role']
        ]);
        if ($request->role == "election admin") {
            electionAdmin::create([
                'user_id' => $u->id,
                'constituency_id' => constituency::where('name', '=', $user['constituency'])->get()[0]->id
            ]);
        } else if ($request->role == "election officer") {
            electionOfficer::create([
                'user_id' => $u->id,
                'polling_station_id' => pollingStation::where('name', '=', $user['polling_station'])->get()[0]->id
            ]);
        }
        Mail::to($u)->queue(new SendPassword($u, $user['password']));
        session()->flash('success', 'User successfully created');
        return redirect()->back();
    }
    function editUser(usr $id)
    {
        return view('admin.edit', ['user' => $id, 'db' => $this->adminLinks]);
    }
    public function updateUser(Request $request)
    {
        try {
            $role = $request->role;
            $rule = [
                'name' => 'required|max:32',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'role' => 'required'
            ];
            if ($role == "election admin") {
                $rule['constituency'] = [Rule::requiredIf(fn() => $role == "election admin"), Rule::exists('constituencies', 'name')];
            }
            if ($role == "election officer") {
                $rule['polling_station'] = [Rule::requiredIf(fn() => $role == "election officer"), Rule::exists('polling_stations', 'name')];
            }
            $update_user = $request->validate($rule);
            $user = usr::find($request->id);
            $user->name = $update_user['name'];
            $user->email = $update_user['email'];
            $user->role = $update_user['role'];
            if ($user->role == "election admin") {
                electionAdmin::updateOrCreate(
                    ['user_id' => $user->id],
                    ['constituency_id' => constituency::where('name', '=', $update_user['constituency'])->get()[0]->id]
                );
                if (electionOfficer::where('user_id', $user->id)->exists()) {
                    electionOfficer::where('user_id', $user->id)->firstOrFail()->delete();
                }
            }
            if ($user->role == "election officer") {
                electionOfficer::updateOrCreate(
                    ['user_id' => $user->id],
                    ['polling_station_id' => pollingStation::where('name', '=', $update_user['polling_station'])->get()[0]->id]
                );
                if (electionAdmin::where('user_id', $user->id)->exists()) {
                    electionAdmin::where('user_id', $user->id)->firstOrFail()->delete();
                }
            }
            if ($user->role == "managment") {
                if (electionAdmin::where('user_id', $user->id)->exists()) {
                    electionAdmin::where('user_id', $user->id)->firstOrFail()->delete();
                }
                if (electionOfficer::where('user_id', $user->id)->exists()) {
                    electionOfficer::where('user_id', $user->id)->firstOrFail()->delete();
                }
            }
            $user->save();
            session()->flash('success', 'data successfully Updated');
        } catch (Exception $th) {
            return response('error ocured', 500);
        }
        return redirect('/admin/manage-users');
    }
    public function editProfile()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }
    public function updateProfile(Usr $usr, Request $request)
    {
        $user = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $usr->id
        ]);
        $usr->name = $user['name'];
        $usr->email = $user['email'];
        $usr->save();
        session()->flash('success', 'data successfully Updated');
        return redirect()->back();
    }
    public function changePassword(usr $usr, Request $request)
    {
        $user = $request->validate([
            'cpass' => 'required',
            'newpass' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()]
        ]);
        if (!Hash::check($user['cpass'], $usr->password)) {
            return back()->withErrors([
                'cpass' => 'wrong password'
            ]);
        }
        $usr->password = $user['newpass'];
        $usr->save();
        session()->flash('success', 'password successfully Updated');
        return redirect()->back();
    }
}
