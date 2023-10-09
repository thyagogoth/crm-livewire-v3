<x-card title="Password Recovery" shadow class="mx-auto w-[350px] bg-base-300">

    @if($message)
        <x-alert
            icon="o-exclamation-triangle"
            class="alert-success pb-4 text-sm text-white"
            shadow
        >
            <p class="text-xs">{{ $message }}</p>
        </x-alert>
    @endif

    <x-form wire:submit="startPasswordRecovery" class="mt-3">
        <x-input label="Email" wire:model="email"/>
        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:navigate href="{{ route('auth.login') }}" class="link link-primary text-sm">
                    already have an account?
                </a>
                <div>
                    <x-button label="Recovery" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
