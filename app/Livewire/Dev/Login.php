<?php

namespace App\Livewire\Dev;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read Collection|User[] $users
 */
class Login extends Component
{
    public ?int $selectedUser = null;

    public function render(): View
    {
        return view('livewire.dev.login');
    }

    #[Computed]
    public function users(): Collection
    {
        return \App\Models\User::orderBy('name', 'asc')->get();
    }

    public function login(): void
    {
        $this->validate([
            'selectedUser' => 'required|exists:users,id',
        ]);

        auth()->loginUsingId($this->selectedUser);

        $this->redirect(route('dashboard'));
    }
}
