<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use App\Models\Table;
use Livewire\Component;
use App\Http\Livewire\Modal;
use App\Models\OrderReceipt;
use App\Models\Configuration;
use App\Events\OrderUpdatedEvent;
use Illuminate\Support\Facades\DB;
use App\Events\AnyOrderUpdatedEvent;
use Illuminate\Support\Facades\Auth;

class Checkout extends Modal
{
    public $orderDetails = [];
    public $orderNumber;
    public $receiptNumber;
    public $order;

    public $subTotal;
    public $serviceCharge;
    public $totalPrice;
    public $enableServiceCharge;

    public $cash;
    public $change;
    public $paymentType;
    public $refNo;

    public $enableDiscount;
    public $discount;
    public $discountType;

    public $config;
    public $receiptName;

    protected $listeners = [
        'checkOut' => 'checkOut',
        'close' => 'close',
    ];

    public function mount()
    {
        $this->config = Configuration::first();
    }

    public function updatedEnableServiceCharge()
    {
        $this->computeServiceCharge();
    }

    public function checkOut(Order $order)
    {
        $this->toggleModal();

        $this->table = $order->table() ?? '';
        $this->order = $order;
        $this->orderNumber = $order->order_number;
        $this->receiptName = '';
        $this->paymentType = 'cash';
        $this->refNo = null;

        foreach ($order->orderDetails as $item) {

            $this->orderDetails[] = [
                'name' => $item->dish->name,
                'side_dish' => $item->side_dishes ? $item->side_dishes['side_name'] : null,
                'quantity' => $item->pcs,
                'price' => $item->price,
            ];
        }
        foreach ($order->customOrderDetails as $item) {

            $this->orderDetails[] = [
                'name' => $item->name,
                'quantity' => $item->pcs,
                'price' => $item->price,
            ];
        }

        $this->enableDiscount = $order->enable_discount;
        $this->discount = $order->discount_option;
        $this->discountType = $order->discount_type;
        $this->enableServiceCharge = $order->enable_tip;

        $this->subTotal = $order->totalPriceWithoutDiscount();

        $this->computeServiceCharge();

    }

    public function close()
    {
        $this->toggleModal();
        $this->reset(['cash', 'change', 'orderDetails']);
    }

    public function computeServiceCharge()
    {
        if($this->enableServiceCharge) {
            if($this->order->action == "Dine In")
                $this->serviceCharge = $this->order->totalPrice() * ($this->config->tip / 100);
            else
                $this->serviceCharge = $this->config->take_out_charge;
        }else{
            $this->serviceCharge = 0;
        }
        $this->totalPrice = $this->order->totalPrice() + $this->serviceCharge;
    }


    public function updatingRefNo($value)
    {
        $this->resetErrorBag('refNo');
    }


    public function confirmCheckOut()
    {
        if(strlen($this->cash) >= 10)
        {
            $this->addError('cash', 'Max length exceeded. Maximum: 10 digits');
            return;
        }

        if ($this->totalPrice > $this->cash) {
            $this->addError('cash', 'You do not have enough cash');
            return;
        }

        if($this->paymentType == 'check')
        {
            if($this->refNo == '') {
                $this->addError('refNo', 'Reference Number is required');
                return;
            }
        }

        DB::transaction(function () {
            if (count($this->order->tables) > 0) {
                $this->order->tables()->detach();
            }

            $this->order->update([
                'checked_out' => true,
                'total' => $this->totalPrice,
                'cash' => $this->cash,
                'change' => $this->change,
                'tip' => $this->enableServiceCharge ? $this->config->tip : 0,
                'ref_no' => $this->paymentType == 'check' ? $this->refNo : null,
            ]);

            $receipts = $this->order->orderReceipts;

            if($this->order->billing_type == "multiple")
            {
                $amount = $this->totalPrice / $this->order->orderReceipts->count();
            }

            foreach($receipts as $receipt)
            {
                $r = OrderReceipt::find($receipt->id);
                if($r->amount != null){
                    $r->update([
                        'receipt_no' => $this->config->receipt_no,
                    ]);
                }else{
                    $r->update([
                        'receipt_no' => $this->config->receipt_no,
                        'amount' => $amount ?? $this->totalPrice,
                    ]);
                }

                $this->config->increment('receipt_no');
            }
            $this->dispatchBrowserEvent('printPO', ['orderId' => $this->order->id]);

            event(new AnyOrderUpdatedEvent());
            $this->close();
        });


    }

    public function render()
    {
        return view('livewire.order.checkout');
    }
}
