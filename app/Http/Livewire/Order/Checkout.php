<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use App\Models\Table;
use Livewire\Component;
use App\Http\Livewire\Modal;
use App\Models\Configuration;
use App\Events\OrderUpdatedEvent;
use App\Models\OrderReceipt;

class Checkout extends Modal
{
    public $orderDetails = [];
    public $orderNumber;
    public $receiptNumber;
    public $order;
    public $totalPrice;
    public $cash;
    public $change;
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

    public function checkOut(Order $order)
    {
        $this->toggleModal();
        //$this->orderDetails = $order->orderDetails;

        // dd($order->orderDetails);
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
        $this->discount = $order->discount;
        $this->discountType = $order->discount_type;

        $this->totalPrice = $order->totalPrice();
        $this->table = $order->table() ?? '';
        $this->order = $order;
        $this->orderNumber = $order->order_number;
        $this->receiptName = '';
    }

    public function close()
    {
        $this->toggleModal();
        $this->reset(['cash', 'change', 'orderDetails']);
    }

    public function computeChange()
    {
        $this->resetErrorBag();
        (float)$this->change = (float)$this->cash - (float)$this->totalPrice;
    }

    public function confirmCheckOut()
    {
        if ($this->totalPrice > $this->cash) {
            $this->addError('cash', 'You do not have enough cash');
            return;
        }
        if (count($this->order->tables) > 0) {

            $this->order->tables()->detach();
        }

        $this->order->update([
            'checked_out' => true,
            'total' => $this->totalPrice,
            'cash' => $this->cash,
            'change' => $this->change,
            'tip' => $this->config->tip,
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

        event(new OrderUpdatedEvent());
        $this->close();
    }

    public function render()
    {
        return view('livewire.order.checkout');
    }
}
