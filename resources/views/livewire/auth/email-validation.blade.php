<x-card title="E-mail validation" shadow class="mx-auto w-[350px] bg-base-300">
    <x-toast />

    @if($sendNewCodeMessage)
        <x-alert
            icon="o-envelope"
            class="alert-warning pb-4 text-sm"
            shadow>
            {{ $sendNewCodeMessage }}
        </x-alert>
    @endif

    <x-form wire:submit="handle" class="mt-3">
        <p>
            We sent you a code. Please check your email and enter the code below.
        </p>
        <x-input label="Code" wire:model="code"/>

        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:click="sendNewCode" class="link link-primary text-sm">
                    Send a new code
                </a>
                <div>
                    <x-button label="Check code" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
