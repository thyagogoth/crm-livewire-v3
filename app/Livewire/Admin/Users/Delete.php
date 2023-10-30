<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Notifications\UserDeletedNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{On, Rule};
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;

    public ?User $user = null;

    public ?string $email = null;

    public bool $modal = false;

    #[Rule(['required', 'confirmed'])]
    public string $confirmation = '';

    public ?string $confirmation_confirmation = null;

    public function render(): View
    {
        return view('livewire.admin.users.delete');
    }

    #[On('user::deletion')]
    public function openConfirmationFor(int $userId): void
    {
        $this->user         = User::select('id', 'name', 'email')->find($userId);
        $this->confirmation = 'user/' . $this->user->email;
        $this->modal        = true;
    }

    public function destroy(): void
    {
        $this->validate();

        if($this->user->is(auth()->user())) {
            $this->addError('confirmation', "You can't delete yourself bro.");

            return;
        }

        $this->user->delete();
        $this->user->notify(new UserDeletedNotification());

        $this->toast(
            type: 'success',
            title: 'User deleted successfully.',
            description: null,                  // optional (text)
            position: 'toast-top toast-end',    // optional (daisyUI classes)
            timeout: 3000,                      // optional (ms)
            redirectTo: null                    // optional (uri)
        );
        $this->dispatch('user::deleted');
        $this->reset('modal');
    }
}
