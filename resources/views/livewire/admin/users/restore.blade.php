<x-modal wire:model="modal"
         title="Restore Confirmation"
         subtitle="You are restoring access for the user {{ $user?->name }}"
         separator>

    @error('confirmation')
    <x-alert icon="o-exclamation-triangle" class="alert-error mb-4">
        {{ $message }}
    </x-alert>
    @enderror

    <div>
        To confirm, type: <strong>RESTORE</strong> below
        <x-input
            class="input-sm mt-1"
{{--            label="Type RESTORE` to confirm the restoration"--}}
            wire:model="confirmation_confirmation"
        />
    </div>

    <x-slot:actions>
        <x-button label="Cancel" @click="$wire.modal = false"/>
        <x-button label="Confirm" class="btn-primary" spinner wire:click="restore"/>
    </x-slot:actions>
</x-modal>
