<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Notifications\UserRestoredAccessNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{On, Rule};
use Livewire\Component;
use Mary\Traits\Toast;

class Restore extends Component
{
    use Toast;

    public ?User $user = null;

    public bool $modal = false;

    #[Rule(['required', 'confirmed'])]
    public string $confirmation = 'RESTORE';

    public ?string $confirmation_confirmation = null;

    public function render(): View
    {
        return view('livewire.admin.users.restore');
    }

    #[On('user::restoring')]
    public function openConfirmationFor(int $userId): void
    {
        $this->user  = User::select('id', 'name')->withTrashed()->find($userId);
        $this->modal = true;
    }

    public function restore(): void
    {
        $this->validate();

        if($this->user->is(auth()->user())) {

            $this->addError('confirmation', "You can't restore yourself, bro.");

            return;
        }

        $this->user->restore();
        $this->user->restored_at = now();
        $this->user->restored_by = auth()->user()->id;
        $this->user->save();

        $this->user->notify(new UserRestoredAccessNotification());
        $this->success('User restored successfully.');
        $this->dispatch('user::restored');
        $this->reset('modal');
    }
}
