<?php

namespace App\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\{Auth, RateLimiter};
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class Login extends Component
{
    use Toast;

    #[Rule(['required', 'email'])]
    public ?string $email = null;

    #[Rule(['required'])]
    public ?string $password = null;

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.guest');
    }

    public function submit()
    {

        $this->validate();

        $user = auth()->attempt([
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        if(Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            //            session()->flash('message', "You are Login successful.");
            $this->redirect(RouteServiceProvider::HOME);
        } else {

            $this->toast(
                type: 'error',
                title: 'Oops!',
                description: 'email and password are wrong.'                  // optional (text)
            );
        }

    }

    public function tryToLogin(): void
    {

        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            $this->addError('rateLimiter', trans('auth.throttle', [
                'seconds' => RateLimiter::availableIn($this->throttleKey()),
            ]));

            return;
        }

        $this->validate();

        $user = auth()->attempt([
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {

            RateLimiter::hit($this->throttleKey());

            $this->addError('invalidCredentials', trans('auth.failed'));

            $this->toast(
                type: 'error',
                title: 'Oops!',
                description: 'email and password are wrong.'                  // optional (text)
            );

            return;
        }

        $this->redirect(route('dashboard'));
    }

    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
