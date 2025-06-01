<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Reactive;

use Livewire\Component;

class ForgotPassword extends Component
{
    #[Validate('email')]
    #[Validate('exists:users', message: 'The email does not exist')]
    #[Validate('required')]
    public $email = '';
    public $success = false;
    public $failed = false;
    public $disabled = false;
    public $failedMessage = "Failed! to send an Email";
    public $successMessage = "Rest Link Sent!";
    public function sendEmail()
    {
        $this->validate();
        try {
            $status = Password::sendResetLink(['email' => $this->email]);
            if ($status === Password::RESET_LINK_SENT) {
                $this->success = true;
            } else {
                $this->failed = true;
            }
        } catch (\Throwable $th) {
            $this->failed = true;
        }
    }
    public function render()
    {
        return view('livewire.forgot-password');
    }
}
