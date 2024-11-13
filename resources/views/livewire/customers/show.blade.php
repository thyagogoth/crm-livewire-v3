<div>
    <x-header separator>
        <x-slot:title>
            Customer | {{ $customer->name }}
        </x-slot:title>
    </x-header>

    <div class="grid grid-cols-3 gap-4 ">
        <div class="bg-base-200 rounded-md p-4 space-y-2 text-base gap-4 flex flex-col">
            <div class="space-y-1">
                <x-info.title>Personal Info</x-info.title>
                <x-info.data title="Name">{{ $customer->name }}</x-info.data>
                <x-info.data title="Gender"> {{ $customer->gender }} </x-info.data>
                <x-info.data title="Age"> {{ $customer->age }} </x-info.data>
            </div>

            <div class="space-y-1">
                <x-info.title>Company Info</x-info.title>
                <x-info.data title="Company"> {{ $customer->company }} </x-info.data>
                <x-info.data title="Position"> {{ $customer->position }} </x-info.data>
            </div>

            <div class="space-y-1">
                <x-info.title>Contact Info</x-info.title>
                <x-info.data title="Email"> {{ $customer->email }} </x-info.data>
                <x-info.data title="Phone"> {{ $customer->phone }} </x-info.data>
                <x-info.data title="Linkedin"> {{ $customer->linkedin }} </x-info.data>
                <x-info.data title="Facebook"> {{ $customer->facebook }} </x-info.data>
                <x-info.data title="Twitter"> {{ $customer->twitter }} </x-info.data>
                <x-info.data title="Instagram"> {{ $customer->instagram }} </x-info.data>
            </div>

            <div class="space-y-1">
                <x-info.title>Address Info</x-info.title>
                <x-info.data title="Address"> {{ $customer->address }} </x-info.data>
                <x-info.data title="City"> {{ $customer->city }} </x-info.data>
                <x-info.data title="State"> {{ $customer->state }} </x-info.data>
                <x-info.data title="Country"> {{ $customer->country }} </x-info.data>
                <x-info.data title="Zip"> {{ $customer->zip }} </x-info.data>
            </div>

            <div class="space-y-1">
                <x-info.title>Record Info</x-info.title>
                <x-info.data title="Created At"> {{ $customer->created_at->diffForHumans() }} </x-info.data>
                <x-info.data title="Updated At"> {{ $customer->updated_at->diffForHumans() }} </x-info.data>
            </div>
        </div>
        <div class="bg-base-200 rounded-md text-base col-span-2">
            <div class="py-2 bg-base-100 rounded-t-md w-full space-x-2 px-0">
                <x-ui.tab class="uppercase" :href="route('customers.show', [$customer, 'opportunities'])">Opportunities</x-ui.tab>
                <x-ui.tab class="uppercase" :href="route('customers.show', [$customer, 'tasks'])">Tasks</x-ui.tab>
                <x-ui.tab class="uppercase" :href="route('customers.show', [$customer, 'notes'])">Notes</x-ui.tab>
            </div>

            <div class="p-4 w-full">
                @livewire("customers.$tab.index", ["customer" => $customer])
            </div>
        </div>
    </div>
</div>
