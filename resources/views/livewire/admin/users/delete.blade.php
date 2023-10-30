<x-modal wire:model="modal"
         title="Deletion Confirmation"
         subtitle="You are deleting the user {{ $user?->name }}..."
         separator>

    @error('confirmation')
    <x-alert icon="o-exclamation-triangle" class="alert-error mb-4">
        {{ $message }}
    </x-alert>
    @enderror

    <div>

        To confirm, type: <strong>user/{{ $user?->email }}</strong> below

        <x-input
            class="input-md mt-1"
            placeholder="type confirmation here"
            wire:model="confirmation_confirmation"
            icon="o-lock-closed"
        />
    </div>

    <x-slot:actions>
        <x-button label="Cancel" @click="$wire.modal = false"/>
        <x-button label="Confirm" class="btn-primary" wire:click="destroy"/>
    </x-slot:actions>

</x-modal>
