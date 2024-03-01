<?php

namespace App\Livewire\Auth;

use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class EmailValidation extends Component
{
    public ?string $code = null;

    public function render(): View
    {
        return view('livewire.auth.email-validation');
    }

    public function handle(): void
    {
        $this->validate([
            'code' => function (string $attribute, mixed $value, Closure $fail) {
                if ($value !== auth()->user()->validation_code) {
                    $fail("The {$attribute} is invalid.");
                }
            },
        ]);

        $user = auth()->user();

        if ($user->validation_code === (int) $this->code) {
            $user->email_verified_at = now();
            $user->save();

            session()->flash('success', 'Your email has been verified!');

            $this->redirect(route('home'));
        } else {
            session()->flash('error', 'The code is invalid.');
        }
    }

    public function sendNewCode()
    {
        $user = auth()->user();

        $user->validation_code = random_int(100000, 999999);
        $user->save();

        $user->notify(new \App\Notifications\Auth\ValidationCodeNotification());
    }
}
