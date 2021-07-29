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
        $tables = Table::query();
        $takeOuts = Order::where('action', 'Take Out')->where('checked_out', 0);
        $deliveries = Order::where('action', 'Delivery')->where('checked_out', 0);

        if (Auth::user()->hasRole('waiter')) {
            //
            $table_ids = Auth::user()->assignTables->pluck('id');
            $tables->whereIn('id', $table_ids);
            $takeOuts->where('waiter_id', Auth::user()->id);
            $deliveries->where('waiter_id', Auth::user()->id);
        }

        $takeOuts = $takeOuts->get();
        $deliveries = $deliveries->get();
        $tables = $tables->get();

        return view('livewire.order.service-type', [
            'tables' => $tables,
            'takeOuts' => $takeOuts,
            'deliveries' => $deliveries,
        ]);
    }
}
