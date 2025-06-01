<?php

namespace App\Livewire;

use App\Http\Controllers\ElectionOfficerController;
use App\Mail\sendNewToken;
use App\Mail\sendTokenRejected;
use App\Models\Complaints;
use App\Models\TokenRegenerationRequest;
use App\Models\User;
use App\Models\voter;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Symfony\Component\Mailer\Transport\SendmailTransportFactory;

class Modal extends Component
{
    public $show = false;
    public $message = "";
    public $action = "";
    public $param = null;

    public $listeners = [
        'showConfirm' => 'showConfirmation',
        'showSuccess' => 'showSuccessMessage',
        'deleteItem' => 'deleteItem',
        'activateItem' => 'activateItem',
        'approveItem' => 'approveItem',
        'rejectItem' => 'rejectItem',
        'resolveItem' => 'resolveItem'
    ];

    public function showConfirmation($message, $action, $param = null)
    {
        $this->message = $message;
        $this->action = $action;
        $this->param = $param;
        $this->show = true;
    }
    public function showSuccessMessage($message)
    {
        $this->message = $message;
        $this->show = true;
    }
    public function confirm()
    {
        $this->dispatch($this->action, $this->param);
        $this->show = false;
    }
    public function deleteItem($itemId)
    {
        User::find($itemId)?->delete();
        $this->action = false;
        $this->dispatch('showSuccess', 'Item deactivated successfully!');
    }
    public function resolveItem($itemId)
    {
        $comp = Complaints::find($itemId);
        $comp->status = "resolved";
        $comp->save();
        $this->dispatch('showSuccess', 'Item resolved successfully!');
    }
    public function activateItem($itemId)
    {
        $user = User::withTrashed()->find($itemId);
        $user->restore();
        $this->action = false;
        $this->dispatch('showSuccess', 'Item Activated successfully!');
    }
    public function approveItem($itemId)
    {
        $request = TokenRegenerationRequest::find($itemId);
        $voter = voter::find($request->voter_id);
        $generator = new ElectionOfficerController();
        $generator->generateToken($voter);
        $request->status = 'approved';
        $request->save();
        Mail::to($voter)->queue(new sendNewToken($voter));
        $this->dispatch('showSuccess', 'Item Approved successfully!');
    }
    public function rejectItem($itemId)
    {
        $request = TokenRegenerationRequest::find($itemId);
        $voter = voter::find($request->voter_id);
        $voter->token = "";
        $voter->save();
        $request->status = 'rejected';
        $request->save();
        Mail::to($voter)->queue(new sendTokenRejected($voter));
        $this->dispatch('showSuccess', 'Item Rejected successfully!');
    }
    public function close()
    {
        $this->show = false;
        $this->dispatch('force-refresh');
        if ($this->action == "")
            return redirect()->back();
    }
    public function render()
    {
        return view('livewire.modal', [
            'users' => User::withTrashed()->get(),
        ]);
    }
}
