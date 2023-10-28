<?php

namespace App\Livewire\Admin\Users;

use App\Enums\Can;
use App\Models\{Permission, User};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\{Component, WithPagination};

/**
 * @property-read Collection|User[] $users
 * @property-read array $headers
 */
class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public array $search_permissions = [];

    public bool $search_trash = false;

    public Collection $permissionsToSearch;

    public string $sortDirection = 'desc';

    public string $sortColumnBy = 'id';

    public int $perPage = 15;

    public function mount(): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);
        $this->filterPermissions();
    }

    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    public function updatedPerPage($value): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        $this->validate(['search_permissions' => 'exists:permissions,id']);

        return User::query()
            ->with('permissions')
            ->when(
                $this->search,
                fn (Builder $q) => $q
                    ->where(function (Builder $query) {
                        $query->where(
                            DB::raw('lower(name)'), /** @phpstan-ignore-line */
                            'like',
                            '%' . strtolower($this->search) . '%'
                        )
                        ->orWhere(
                            'email',
                            'like',
                            '%' . strtolower($this->search) . '%'
                        );
                    })
            )
            ->when(
                $this->search_permissions,
                fn (Builder $q) => $q->whereHas('permissions', function (Builder $query) {
                    $query->whereIn('id', $this->search_permissions);
                })
            )
            ->when(
                $this->search_trash,
                fn (Builder $q) => $q->onlyTrashed()/** @phpstan-ignore-line */
            )
            ->orderBy($this->sortColumnBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'name', 'label' => 'Name', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'email', 'label' => 'Email', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'permissions', 'label' => 'Permissions', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
        ];
    }

    public function filterPermissions(?string $value = null): void
    {
        $this->permissionsToSearch = Permission::query()
            ->when($value, fn (Builder $q) => $q->where('key', 'like', "%$value%"))
            ->orderBy('key')
            ->get();
    }

    public function sortBy(string $column, string $direction): void
    {
        $this->sortColumnBy  = $column;
        $this->sortDirection = $direction;
    }

    public function delete($id): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);

        User::query()
            ->where('id', $id)
            ->delete();
    }

    public function restore($id): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);

        $user = User::withTrashed()
            ->where('id', $id)
            ->restore();
    }
}
