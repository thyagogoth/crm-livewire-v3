<?php

namespace App\Livewire\Auth\Password;

use App\Models\User;
use App\Notifications\PasswordRecoveryNotification;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Recovery extends Component
{

    public ?string $message = null;

    #[Rule(['email', 'required'])]
    public ?string $email = null;

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.auth.password.recovery');
    }

    public function startPasswordRecovery(): void
    {

        $this->validate();

        Password::sendResetLink([
            'email' => $this->email
        ]);

        $this->message = "You will receive an email with the password recovery link";
    }
}
