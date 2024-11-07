<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Support\Table\Header;
use App\Traits\Livewire\HasTable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\{Builder};
use Livewire\{Attributes\On, Component, WithPagination};

/**
 * @property-read LengthAwarePaginator|Customer[] $customers
 * @property-read array $headers
 */
class Index extends Component
{
    use WithPagination;
    use HasTable;

    public bool $search_trash = false;

    #[On('customer::reload')]
    public function render(): View
    {
        return view('livewire.customers.index');
    }

    public function query(): Builder
    {
        return Customer::query()
            ->when(
                $this->search_trash,
                fn (Builder $q) => $q->onlyTrashed()
            );
    }

    public function searchColumns(): array
    {
        return ['name', 'email'];
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('id', '#'),
            Header::make('name', 'Name'),
            Header::make('email', 'Email'),
        ];
    }
}
