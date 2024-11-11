<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased">
    <x-toast />

    @if (session('impersonate'))
        <livewire:admin.users.stop-impersonate />
    @endif

    @if (!app()->environment('production'))
        <x-devbar />
    @endif

    <x-main full-width>

        <x-slot:sidebar drawer="main-drawer" collapsible class="pt-3 text-white bg-sky-800">
            <div class="ml-5 text-4xl font-black text-yellow-500 hidden-when-collapsed">mary</div>
            <div class="ml-5 text-4xl font-black text-orange-500 display-when-collapsed">m</div>
            <x-menu activate-by-route active-bg-color="bg-base-300/10">
                @if ($user = auth()->user())
                    <x-list-item :item="$user" sub-value="username" no-separator no-hover
                        class="!-mx-2 mt-2 mb-5 border-y border-y-sky-900">
                        <x-slot:actions>
                            <div class="tooltip tooltip-left" data-tip="logoff">
                                <x-button icon="o-power" class="btn-circle btn-ghost btn-xs"
                                    @click="$dispatch('logout')" />
                            </div>
                        </x-slot:actions>
                    </x-list-item>
                @endif

                <x-menu-item title="Home" icon="o-home" :link="route('dashboard')" />
                <x-menu-item title="Customers" icon="o-building-storefront" :link="route('customers')" />
                <x-menu-item title="Opportunities" icon="o-currency-dollar" :link="route('opportunities')"/>

                @can(\App\Enums\Can::BE_AN_ADMIN->value)
                    <x-menu-sub title="Admin" icon="o-lock-closed">
                        <x-menu-item title="Dashboard" icon="o-chart-bar-square" :link="route('admin.dashboard')" />
                        <x-menu-item title="Users" icon="o-users" :link="route('admin.users')" />
                    </x-menu-sub>
                @endcan

            </x-menu>
        </x-slot:sidebar>

        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    <livewire:auth.logout />


</body>

</html>
