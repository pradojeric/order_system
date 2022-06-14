<?php

namespace App\Http\Livewire\Auth\Report;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Report;
use DB;

class Create extends Component
{

    public $dateType;
    public $date;
    public $tempDate;
    public $date2 = "";
    public $spoilages = [];
    public $dishes = [];
    public $total;
    public $remit = 0;
    public $overalls;
    public $unpaids;
    public $latePayments;
    public $totalRemittance;

    protected $rules = [
        'remit' => ['required', 'numeric' ,'min:1'],
    ];

    public function mount()
    {
        $this->date = now()->toDateString();
        $this->dateType = 'single';
        $this->dishes = Dish::orderBy('name')->orderBy('properties')->get()->toArray();
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
    }

    public function prevDate()
    {
        $date = Carbon::parse($this->date);
        $date->subDay();
        $this->date = $date->toDateString();
    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        $late = [];

        foreach($this->latePayments as $l) {
            $full_name = $l->full_name;
            $description = $l->by ? "care off {$l->by}" : "";
            $date = $l->paid_on->format('M d');
            $price = number_format($l->total, 2, '.', ',');

            $late[] = [
                'name' =>  "$full_name - $description ($date)",
                'price' => $price,
            ];
        }

        $unpaids = [];

        foreach($this->unpaids as $u) {
            $full_name = $u->full_name;
            $description = $u->by ? "care off {$u->by}" : "";
            $price = number_format($u->total, 2, '.', ',');
            $unpaids[] = [
                'name' =>  "$full_name - $description",
                'price' => $price,
            ];
        }


        Report::create([
            'date' => $this->date,
            'remitted' => $this->remit,
            'total_unpaid' => $this->unpaids->sum('total'),
            'late_payments' => $this->latePayments->sum('total'),
            'total_remittance' => $this->totalRemittance,
            'spoilages' => json_encode($this->spoilages),
            'late' => json_encode($late),
            'unpaid' => json_encode($unpaids),
        ]);

        DB::commit();

        return redirect('/admin/reports');
    }

    public function render()
    {
        $this->overalls = Category::with([
            'dishes' => function ($dish) {
                $dish->orderBy('name');
            },
            'dishes.orderDetails' => function ($order) {
                $order->when($this->dateType == 'single', function($query){
                    $query->whereDate( 'created_at', $this->date );
                });
            },
            'dishes.orderDetails.order' => function ($order) {
                $order->when($this->dateType == 'single', function($query){
                    $query->whereDate( 'created_at', $this->date );
                });
            },
        ])
        ->get();

        $this->unpaids = Order::where('checked_out', false)->get();

        $this->latePayments = Order::whereDate('paid_on', $this->date)->get();


        $this->total = $this->overalls->sum( function ($overall) {
            return $overall->dishes->sum( function ($dish) {
                return $dish->orderDetails->sum('price');
            });
        });

        return view('livewire.auth.report.create');
    }
}
