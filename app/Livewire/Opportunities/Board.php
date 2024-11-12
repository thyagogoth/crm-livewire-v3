<?php

namespace App\Livewire\Opportunities;

use App\Models\Opportunity;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read Collection|Opportunity[] $opportunities
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

    public function updateOppurtunities($data)
    {

        $order = collect();

        foreach ($data as $group) {
            $order->push(
                collect($group['items'])
                    ->map(fn ($i) => $i['value'])
                    ->join(',')
            );
        }

        $open      = explode(',', $order[0]);
        $won       = explode(',', $order[1]);
        $lost      = explode(',', $order[2]);
        $sortOrder = $order->join(',');

        DB::table('opportunities')->whereIn('id', $open)->update(['status' => 'open']);
        DB::table('opportunities')->whereIn('id', $won)->update(['status' => 'won']);
        DB::table('opportunities')->whereIn('id', $lost)->update(['status' => 'lost']);
        DB::table('opportunities')->update(['sort_order' => DB::raw("FIELD(id, $sortOrder)")]);

    }
}
