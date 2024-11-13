<?php

namespace App\Livewire\Customers\Tasks;

use App\Actions\DataSort;
use App\Models\Customer;
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

    public function updateTaskOrder(array $items)
    {
        (new DataSort('tasks', $items, 'value'))->run();
    }
}
