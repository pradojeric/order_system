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

    public $dateType;
    public $date;
    public $tempDate;
    public $date2 = "";
    public $action;

    public $cash;
    public $creditCard;
    public $total;

    public $paginate = 15;

    public function mount()
    {
        $this->date = now()->toDateString();
        $this->action = 'all';
        $this->dateType = 'single';
    }

    public function updatedDateType($value)
    {

        if($value == 'range')
        {
            $this->tempDate = $this->date;
            $this->date = Carbon::parse($this->date)->startOfMonth()->toDateString();
            $this->date2 = Carbon::parse($this->date)->endOfMonth()->toDateString();

        }else
        {
            $this->date = $this->tempDate;
            $this->date2 = "";
        }
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
        $orders =  Order::with([
            'waiter' => function($query){
                $query->withTrashed();
            },
        ])->where('checked_out', 1)
            ->when($this->dateType == 'single', function($query){
                $query->whereDate('created_at', $this->date);
            })
            ->when($this->dateType == 'range', function($query) {
                $query->whereRaw('DATE(created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
            });

        $this->total = $orders->sum('total');
        $this->cash = (clone $orders)->whereNull('ref_no')->sum('total');
        $this->creditCard = (clone $orders)->whereNotNull('ref_no')->sum('total');

        $orders = $orders->when($this->action != 'all', function ($query) {
                    $query->where('action', $this->action);
                })->paginate($this->paginate);

        return view('livewire.auth.report', [
            'orders' =>$orders,
            'dishes' => Dish::leftJoin('order_details', 'dishes.id', 'dish_id')
                ->leftJoin('orders', 'orders.id', 'order_details.order_id')
                ->selectRaw('dishes.name, SUM(pcs) as quantity')
                ->groupBy('dishes.name')
                ->when($this->dateType == 'single', function($query){
                    $query->whereDate('orders.created_at', $this->date);
                })
                ->when($this->dateType == 'range', function($query) {
                    $query->whereRaw('DATE(orders.created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
                })
                ->when($this->action != 'all', function ($query) {
                    $query->where('orders.action', $this->action);
                })
                ->get(),
            'customDishes' => CustomDish::leftJoin('orders', 'orders.id', 'custom_dishes.order_id')
                ->when($this->dateType == 'single', function($query){
                    $query->whereDate('orders.created_at', $this->date);
                })
                ->when($this->dateType == 'range', function($query) {
                    $query->whereRaw('DATE(orders.created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
                })
                ->where('orders.checked_out', 1)
                ->get(),
            'waiters' => User::
                // whereHas('role', function ($role) {
                //     $role->where('name', 'waiter');
                // })
                // ->
                with([
                    'cancelled' => function ($cancel) {
                        $cancel->when($this->dateType == 'single', function($query){
                                $query->whereDate('cancels.created_at', $this->date);
                            })
                            ->when($this->dateType == 'range', function($query) {
                                $query->whereRaw('DATE(cancels.created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
                            });
                        },
                    'orders' => function($order) {
                        $order->when($this->dateType == 'single', function($query){
                            $query->whereDate('orders.created_at', $this->date);
                        })
                        ->when($this->dateType == 'range', function($query) {
                            $query->whereRaw('DATE(orders.created_at) BETWEEN ? AND ?', [$this->date, $this->date2]);
                        });
                    }
                    ]
                )
                ->get(),
        ]);
    }
}
