<?php

namespace App\Http\Livewire\ClickChart;

use Carbon\Carbon;
use App\AffiliateClick;
use Livewire\Component;

class PreviousMonth extends Component
{
    public $year;
    public $clickCount;
    public $monthName;

    public function mount()
    {
        $this->year = date('Y');
        $this->monthName = Carbon::now()->subMonth()->format('F');
        $this->clickCount = AffiliateClick::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
                          ->get()->count();
    }

    public function render()
    {
        return view('livewire.click-chart.previous-month');
    }
}
