<?php

namespace App\Livewire;

use Livewire\Component;

class Welcome extends Component
{
    public int $opportunities = 0;

    public int $sales = 0;

    public int $lost = 0;

    public int $conversion = 0;

    public function render()
    {

        $this->opportunities = \App\Models\Opportunity::query()
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->count();

        $this->sales = \App\Models\Opportunity::query()
            ->where('created_at', '>=', now()->subDays(7))
            ->where('status', 'won')
            ->orderBy('created_at', 'desc')
            ->count();

        $this->lost = \App\Models\Opportunity::query()
            ->where('created_at', '>=', now()->subDays(7))
            ->where('status', 'lost')
            ->orderBy('created_at', 'desc')
            ->count();

        $this->conversion = $this->opportunities > 0 ? round(($this->sales / $this->opportunities) * 100, 2) : 0;

        return view('livewire.admin.dashboard');
    }
}
