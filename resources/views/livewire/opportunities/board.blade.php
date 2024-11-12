<div class="p-2 grid grid-cols-3 gap-4 h-full">

    @foreach($this->opportunities->groupBy('status') as $status => $items)
        <div class="bg-base-200 p-2 rounded-md">
            <x-header :title="$status"
                      subtitle="Total: {{ $items->count() }} opportunities"
                      size="text-lg"
                      class="px-2"
                      separator progress-indicator/>

            <div class="space-y-2 py-2 pt-2 pb-1">
                @foreach($items as $item)
                    <x-card>{{ $item->title }}</x-card>
                @endforeach
            </div>
        </div>
    @endforeach

</div>
