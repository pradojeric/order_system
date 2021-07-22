<?php

namespace App\Http\Livewire\Auth;

use App\Models\CustomDish;
use App\Models\Dish;
use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use App\Models\OrderDetails;
use Carbon\Carbon;
use Livewire\WithPagination;

class Report extends Component
{
    use WithPagination;

    public $date;
    public $action;

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
    }

    public function prevDate()
    {
        $date = Carbon::parse($this->date);
        $date->subDay();
        $this->date = $date->toDateString();
    }

    public function render()
    {

        return view('livewire.auth.report', [
            'orders' => Order::where('checked_out', 1)
                ->whereDate('created_at', $this->date)
                ->when($this->action != 'all', function ($query) {
                    $query->where('action', $this->action);
                })
                ->paginate(16),
            'dishes' => Dish::leftJoin('order_details', 'dishes.id', 'dish_id')
                ->leftJoin('orders', 'orders.id', 'order_details.order_id')
                ->selectRaw('dishes.name, SUM(pcs) as quantity')
                ->groupBy('dishes.name')
                ->whereDate('orders.created_at', $this->date)
                ->when($this->action != 'all', function ($query) {
                    $query->where('orders.action', $this->action);
                })
                ->paginate(16),
            'customDishes' => CustomDish::leftJoin('orders', 'orders.id', 'custom_dishes.order_id')
                ->whereDate('orders.created_at', $this->date)
                ->where('orders.checked_out', 1)
                ->paginate(16),
            'waiters' => User::whereHas('role', function ($role) {
                $role->where('name', 'waiter');
            })
                ->with(['orders' => function ($order) {
                    $order->withTrashed()->whereDate('created_at', $this->date);
                }])
                ->get(),
        ]);
    }
}
