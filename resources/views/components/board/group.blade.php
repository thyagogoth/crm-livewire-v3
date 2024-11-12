@props(['status', 'items'])
<div class="bg-base-200 p-2 rounded-md" wire:key="group-{{ $status }}">

    <x-header
        :title="$status"
        subtitle="Total: {{ $items->count() }} opportunities"
        size="text-lg"
        class="px-2 pb-0 mb-2"
        separator progress-indicator
    />

    <div class="space-y-2 px-2"
         wire:sortable-group.item-group="{{ $status }}"
         wire:sortable-group.options="{ animation: 100 }"
    >


        @forelse($items as $item)
            <x-card class="hover:opacity-60 cursor-grab"
                    wire:sortable-group.handle
                    wire:sortable-group.item="{{ $item->id }}"
                    wire:key="opportunity-{{ $item->id }}"
            > {{ $item->title }} </x-card>
        @empty
            <div wire:key="opportunity-null" class="h-16 border-dashed border-gray-400 border rounded w-full text-center opacity-35 shadow flex items-center justify-center uppercase">
                no opportunities
            </div>
        @endforelse
    </div>
</div>
