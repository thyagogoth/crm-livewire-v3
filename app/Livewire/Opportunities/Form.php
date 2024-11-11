<?php

namespace App\Livewire\Opportunities;

use App\Models\Opportunity;
use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    public ?Opportunity $opportunity = null;

    public string $title = '';

    public string $status = 'open';

    public ?string $amount;

    protected $rules = [
        'title'  => 'required|min:3|max:120',
        'status' => 'required|in:open,won,lost',
        'amount' => 'required',
    ];

    public function setOpportunity(Opportunity $opportunity): void
    {
        $this->opportunity = $opportunity;

        $this->title  = $opportunity->title;
        $this->status = $opportunity->status;
        $this->amount = (string) $opportunity->amount / 100;
    }

    public function create(): void
    {
        $this->validate();

        Opportunity::create([
            'title'  => $this->title,
            'status' => $this->status,
            'amount' => $this->getAmountAsInt(),
        ]);

        $this->reset();
    }

    public function update(): void
    {
        $this->validate();

        $this->opportunity->title  = $this->title;
        $this->opportunity->status = $this->status;
        $this->opportunity->amount = $this->getAmountAsInt();

        $this->opportunity->update();
    }

    private function getAmountAsInt(): int
    {
        $amount = $this->amount;

        if ($amount === null) {
            $amount = 0;
        }

        return (int) ($amount * 100);
    }
}
