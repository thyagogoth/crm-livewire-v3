<div>
    <x-header title="Customers" separator/>

    <div class="flex mb-4 space-x-4 items-center">
        <div class="w-1/3 self-center">
            <x-input label="Search by email or name" icon="o-magnifying-glass" wire:model.live="search"/>
        </div>
        <x-checkbox label="Show Archived Customers" wire:model.live="search_trash" class="checkbox-primary self-center"
                    right tight/>
        <x-select wire:model.live="perPage" :options="[
        ['id' => 5, 'name' => 5],
        ['id' => 15, 'name' => 15],
        ['id' => 25, 'name' => 25],
        ['id' => 50, 'name' => 50],
    ]" label="Records Per Page" class="self-center"/>
        <x-button @click="$dispatch('customer::create')" label="Create a new Customer" icon="o-plus"
                  class="self-center"/>
    </div>


    <x-table :headers="$this->headers" :rows="$this->items">
        @scope('header_id', $header)
        <x-table.th :$header name="id"/>
        @endscope

        @scope('header_name', $header)
        <x-table.th :$header name="name"/>
        @endscope

        @scope('header_email', $header)
        <x-table.th :$header name="email"/>
        @endscope

        @scope('actions', $customer)
        <div class="flex items-center space-x-2">
            @unless($customer->trashed())
                <x-button
                    id="archive-btn-{{ $customer->id }}"
                    wire:key="archive-btn-{{ $customer->id }}"
                    icon="o-trash"
                    @click="$dispatch('customer::archive', { id: {{ $customer->id }}})"
                    spinner class="btn-sm"
                />
            @else
                <x-button
                    id="archive-btn-{{ $customer->id }}"
                    wire:key="restore-btn-{{ $customer->id }}"
                    icon="o-arrow-uturn-left"
                    @click="$dispatch('customer::restore', { id: {{ $customer->id }}})"
                    spinner class="btn-sm"
                />
            @endunless
        </div>
        @endscope
    </x-table>

    {{ $this->items->links(data: ['scrollTo' => false]) }}

    <livewire:customers.create/>
    <livewire:customers.archive/>
    <livewire:customers.restore/>
</div>
