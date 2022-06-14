<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use App\Models\Table;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ServiceType extends Component
{
    public $message = '';

    protected $listeners = [
        'echo:newOrder,AnyOrderUpdatedEvent' => '$refresh',
    ];

    public function refreshComponent()
    {
        session()->flash('message', 'Page updated. Please refresh the page!');
    }

    public function render()
    {
        $orders = Order::with(['orderDetails'])->where('checked_out', 0)->get();

        return view('livewire.order.service-type', [
            'orders' => $orders,
        ]);
    }
}
