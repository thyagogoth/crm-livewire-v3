<x-modal wire:model="modal"
         title="Restore Confirmation"
         subtitle="You are restoring the archived customer {{ $customer?->name }}"
>

    <x-slot:actions>
        <x-button label="Hum... no" @click="$wire.modal = false"/>
        <x-button label="Yes, I am" class="btn-primary" wire:click="restore"/>
    </x-slot:actions>
</x-modal>
