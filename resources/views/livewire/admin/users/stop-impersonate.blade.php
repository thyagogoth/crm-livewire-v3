<div class="bg-orange-400 px-4 p-2 text-sm text-white hover:underline cursor-pointer text-center font-bold" wire:click="stop">
    {{ __("You're impersonating :name, click here to stop the impersonation.", ['name' => $user->name]) }}
</div>
