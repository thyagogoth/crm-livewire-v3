<?php

namespace App\Livewire\Customers\Tasks;

use App\Actions\DataSort;
use App\Models\{Customer, Task};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Index extends Component
{
    public Customer $customer;

    #[On('task::created')]
    public function render(): View
    {
        return view('livewire.customers.tasks.index');
    }

    #[Computed]
    public function notDoneTasks()
    {
        return $this->customer->tasks()->notDone()
            ->orderBy('sort_order')
            ->get();
    }

    #[Computed]
    public function doneTasks()
    {
        return $this->customer->tasks()->done()
            ->orderBy('sort_order')
            ->get();
    }

    public function updateTaskOrder(array $items): void
    {
        (new DataSort('tasks', $items, 'value'))->run();
    }

    public function toggleChecked(int $taskId, string $status): void
    {

        Task::whereId($taskId)
            ->when(
                $status == 'done',
                fn ($query) => $query->update(['done_at' => now()]),
                fn ($query) => $query->update(['done_at' => null])
            );
    }

    public function deleteTask($taskId): void
    {
        Task::whereId($taskId)->delete();
    }
}
