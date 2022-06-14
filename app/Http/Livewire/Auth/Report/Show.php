<?php

namespace App\Http\Livewire\Auth\Report;

use Carbon\Carbon;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Report;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class Show extends Component
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
    public $unpaid;
    public $unpaids;
    public $latePayments;
    public $totalRemittance;

    protected $rules = [
        'remit' => ['required', 'numeric' ,'min:1'],
    ];

    public function mount(Report $report)
    {
        $this->date = $report->date;
        $this->dateType = 'single';
        $this->dishes = Dish::orderBy('name')->orderBy('properties')->get()->toArray();
        $this->spoilages = $report->spoilages;
        $this->unpaid = $report->total_unpaid;
        $this->unpaids = $report->unpaid;
        $this->latePayments = $report->late;
        $this->remit = $report->remitted;
        $this->totalRemittance = $report->total_remittance;

    }

    public function save()
    {
        $this->validate();

        DB::beginTransaction();

        $report = Report::create([
            'remitted' => $this->remit,
            'late_payments' => $this->latePayments->sum('total'),
            'total_remittance' => $this->totalRemittance,
        ]);


        $report->spoilages()->createMany(collect($this->spoilages)->toArray());

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

        // $this->unpaids = Order::where('checked_out', false)->get();

        // $this->latePayments = Order::whereDate('paid_on', $this->date)->get();


        $this->total = $this->overalls->sum( function ($overall) {
            return $overall->dishes->sum( function ($dish) {
                return $dish->orderDetails->sum('price');
            });
        });

        return view('livewire.auth.report.show');
    }
}
