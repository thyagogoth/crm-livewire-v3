<x-card shadow class="mx-auto w-[350px] bg-base-300">
    <x-toast />

    @if($errors->hasAny(['invalidCredentials', 'rateLimiter']))
        @error('invalidCredentials')
        <x-alert
            title="Invalid credentials"
            description="{{ $message }}"
            icon="o-exclamation-triangle"
            class="alert-warning pb-4 text-sm"
            shadow
        />
        @enderror

        @error('rateLimiter')
        <x-alert
            title="Invalid credentials"
            description="{{ $message }}"
            icon="o-exclamation-triangle"
            class="pb-4 text-sm"
            shadow
        />
        @enderror
    @endif

    <x-form wire:submit="tryToLogin" class="mt-3">
        <x-input label="Email" wire:model="email"/>
        <x-input label="Password" wire:model="password" type="password"/>
        <div class="w-full text-right text-sm">
            <a href="{{ route('auth.password.recovery') }}" class="link link-primary">Forgot your password?</a>
        </div>
        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:navigate href="{{ route('auth.register') }}" class="link link-primary text-sm">
                    create new account
                </a>
                <div>
                    <x-button label="Login" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
