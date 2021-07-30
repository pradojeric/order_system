<?php

namespace App\Http\Livewire\Waiter;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    public $date;
    public $action;
    public $total;

    public function mount()
    {
        $this->date = now()->toDateString();
        $this->action = 'all';
    }

    public function nextDate()
    {
        $date = Carbon::parse($this->date);
        $date->addDay();
        $this->date = $date->toDateString();
        $this->resetPage();
    }

    public function prevDate()
    {
        $date = Carbon::parse($this->date);
        $date->subDay();
        $this->date = $date->toDateString();
        $this->resetPage();
    }

    public function render()
    {
        $orders = Auth::user()->orders()
            ->whereDate('created_at', $this->date)
            ->when($this->action != 'all', function ($query) {
                $query->where('action', $this->action);
            });

        $this->total = $orders->sum('total');

        $orders = $orders->paginate(15);

        return view('livewire.waiter.dashboard', [
            'orders' => $orders,
        ]);
    }
}
