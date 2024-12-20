<?php

namespace App\Livewire\Auth\Password;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Component;

class Recovery extends Component
{
    public ?string $message = null;

    #[Rule(['email', 'required'])]
    public ?string $email = null;

    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.auth.password.recovery');
    }

    public function startPasswordRecovery(): void
    {

        $this->validate();

        Password::sendResetLink([
            'email' => $this->email,
        ]);

        $this->message = "You will receive an email with the password recovery link";
    }
}
