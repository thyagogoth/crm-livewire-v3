<?php

namespace App\Livewire\Opportunities;

use App\Actions\DataSort;
use App\Models\Opportunity;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read Collection|Opportunity[] $opportunities
 * @property-read Collection|Opportunity[] $opens
 * @property-read Collection|Opportunity[] $wons
 * @property-read Collection|Opportunity[] $losts
 */
class Board extends Component
{
    public function render(): View
    {
        return view('livewire.opportunities.board');
    }

    #[Computed]
    public function opportunities(): Collection
    {
        return Opportunity::query()
            ->orderByRaw("FIELD(status, 'open', 'won', 'lost')")
//            ->orderByRaw("
//                case
//                    when status = 'open' then 1
//                    when status = 'won' then 2
//                    when status = 'lost' then 3
//                end
//            ")
            ->orderBy('sort_order')
            ->get();
    }

    #[Computed]
    public function opens(): Collection
    {
        return $this->opportunities
            ->where('status', 'open');
    }

    #[Computed]
    public function wons(): Collection
    {
        return $this->opportunities
            ->where('status', 'won');
    }

    #[Computed]
    public function losts(): Collection
    {
        return $this->opportunities
            ->where('status', 'lost');
    }

    public function updateOpportunities(array $data): void
    {
        $order = $this->getItemsInOrder($data);
        $this->updateStatuses($order);
        $this->updateSortOrders($order);
    }

    private function getItemsInOrder(array $data): SupportCollection
    {
        $order = collect();

        foreach ($data as $group) {
            $order->push(
                collect($group['items'])
                    ->map(fn ($i) => $i['value'])
                    ->join(',')
            );
        }

        return $order;
    }

    private function updateStatuses(SupportCollection $collection): void
    {
        foreach (['open', 'won', 'lost'] as $status) {
            $this->updateStatus($status, $collection);
        }
    }

    private function updateStatus(string $status, SupportCollection $collection): void
    {
        $id = match ($status) {
            'open'  => 0,
            'won'   => 1,
            'lost'  => 2,
            default => null
        };

        $list = $collection[$id];
        $ids  = explode(',', $list);

        if (filled($list)) {
            DB::table('opportunities')->whereIn('id', $ids)->update(['status' => $status]);
        }
    }

    private function updateSortOrders(SupportCollection $collection): void
    {
        (new DataSort('opportunities', $collection->filter(fn ($f) => filled($f))))->run();
    }
}
