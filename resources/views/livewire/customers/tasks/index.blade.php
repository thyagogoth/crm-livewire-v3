<div class="p-4">
    {{--<livewire:customers.tasks.create :customer="$customer" />--}}
    <livewire:customers.tasks.create :$customer />

    <div class="uppercase font-bold text-slate-600 text-xs mb-2">
        Pending [{{ $this->notDoneTasks()->count() }}]
    </div>
    <ul class="flex flex-col gap-1 mb-6" wire:sortable="updateTaskOrder" wire:sortable.options="{ animation:100 }">
        @foreach($this->notDoneTasks as $task)
            <li wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}" >
                <button wire:sortable.handle title="{{ __('Drag to reorder') }}" class="cursor-grab">
                    <x-icon name="o-arrows-up-down" class="w-4 h-4 -mt-px opacity-35" />
                </button>
                <input id="task-{{$task->id}}" value="1" @if($task->done_at) checked @endif type="checkbox"
                       wire:click="toggleChecked({{ $task->id }}, 'done')"
                >
                <label for="task-{{ $task->id }}">{{ $task->title }}</label>
                <select>
                    <option>assigned to: {{ $task->assignedTo?->name }}</option>
                </select>
            </li>
        @endforeach
    </ul>

{{--    <hr class="border-dashed border-gray-700 my-2">--}}

    <div class="uppercase font-bold text-slate-600 text-xs mb-2">
        Done Tasks [{{ $this->doneTasks()->count() }}]
    </div>
    <ul class="flex flex-col gap-1">
        @foreach($this->doneTasks as $task)
            <li class="flex gap-2">
                <input id="task-{{$task->id}}" value="1" @if($task->done_at) checked @endif type="checkbox"
                       wire:click="toggleChecked({{ $task->id }}, 'pending')"
                >
                <label for="task-{{ $task->id }}">{{ $task->title }}</label>
                <div class="text-amber-200 text-opacity-40">(assigned to: {{ $task->assignedTo?->name }})</div>
            </li>
        @endforeach
    </ul>

</div>
