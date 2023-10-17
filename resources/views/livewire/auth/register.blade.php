<x-card title="Register" shadow class="mx-auto w-[350px] bg-base-300">
    <x-form wire:submit="submit">
        <x-input label="Name" wire:model="name"/>
        <x-input label="Email" wire:model="email"/>
        <x-input label="Confirm your email" wire:model="email_confirmation"/>
        <x-input label="Password" wire:model="password" type="password"/>
        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:navigate href="{{ route('login') }}" class="link link-primary text-sm">
                    Already registered
                </a>
            </div>
            <div class="w-full flex items-center justify-between">
                <div class="w-full flex justify-between">
                    <x-button label="Reset" type="reset" class="text-sm" />
                    <x-button label="Register" class="btn-primary text-sm" type="submit" spinner="submit" />
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
