<?php

namespace App\Livewire\Customers\Tasks;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
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
        $orders = collect($items)->pluck('value')->join(',');

        DB::table('tasks')
            ->update(['sort_order' => DB::raw("FIELD(id, $orders)")]);
    }
}
