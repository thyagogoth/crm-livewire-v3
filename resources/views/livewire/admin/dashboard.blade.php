<div class="flex container">

    <x-stat title="Opportunities" wire:model="{{ $opportunities }}" value="{{ $opportunities }}" icon="o-currency-dollar" />

    <x-stat
        title="Sales"
        description="This month"
        value="{{ $sales }}"
        icon="o-arrow-trending-up"
   />

    <x-stat
        title="Lost"
        description="This month"
        value="{{ $lost }}"
        icon="o-arrow-trending-down"
    />

    <x-stat
        title="Conversion parcentage"
        description="This month"
        value="{{ $conversion }}%"
        icon="o-arrow-trending-down"
        class="text-orange-500"
        color="text-pink-500"
    />
</div>
