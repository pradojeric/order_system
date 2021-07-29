<?php

namespace App\Http\Livewire\Order\Modal;


use App\Models\Order;
use App\Http\Livewire\Modal;
use App\Events\OrderUpdatedEvent;

class BillingType extends Modal
{
    public $billingType;
    public $totalSegmentBill;
    public $remaining;
    public $isBillEqualPrice;
    public Order $order;
    public $receipts = [ [] ];

    protected $rules = [
        'receipts.*.name' => 'required',
        'receipts.*.address' => 'required',
        'receipts.*.contact' => 'required',
        'receipts.*.amount' => 'numeric',
    ];

    protected $messages = [
        'receipts.*.name.required' => 'Name is required',
        'receipts.*.address.required' => 'Address is required',
        'receipts.*.contact.required' => 'Contact is required',
        'receipts.*.amount.numeric' => 'Amount must be numeric',
    ];

    public function setBillingType()
    {
        $this->toggleModal();
        if($this->order->orderReceipts->count() > 0){

            $amount = $this->order->totalPrice() / $this->order->orderReceipts->count();
            $this->receipts = $this->order->orderReceipts->each(function($r) use ($amount){
                $r['amount'] = $amount;
            })->toArray();
            $this->totalSegmentBill = $this->order->totalPrice();
            $this->remaining = $this->order->totalPrice() - $this->totalSegmentBill;
            $this->isBillEqualPrice = $this->remaining == 0;
        }
    }

    public function updatingBillingType($value)
    {
        if($value == "single")
        {
            foreach($this->receipts as $i => $receipt)
            {
                if($i > 0) unset($this->receipts[$i]);
            }
        }
        if($value == "multiple")
        {
            $this->addReceipient();
        }
    }

    public function updatedReceipts()
    {
        if($this->billingType == "single") return;
        $total = 0;
        foreach($this->receipts as $a)
        {
            $total += (int)$a['amount'] ?? 0;
        }
        $this->totalSegmentBill = $total;
        $this->remaining = $this->order->totalPrice() - $this->totalSegmentBill;
        $this->isBillEqualPrice = $this->remaining == 0;
    }

    public function addReceipient()
    {
        $this->receipts[] = [];
    }

    public function saveReceipts()
    {
        $this->validate();
        if(!$this->isBillEqualPrice && $this->billingType == "multiple")
        {
            $this->addError('equal', 'Segment must equal to total price!');
            return;
        }

        $data = [];
        foreach($this->receipts as $receipt)
        {
            $data[] = [
                'name' => $receipt['name'],
                'address' => $receipt['address'],
                'contact' => $receipt['contact'],
                'amount' => $receipt['amount'] ?? null,
            ];
        }

        $this->order->orderReceipts()->delete();
        $this->order->orderReceipts()->createMany($data);
        $this->order->billing_type = $this->billingType;
        $this->order->save();
        event(new OrderUpdatedEvent($this->order));
        $this->toggleModal();
    }

    public function close()
    {
        $this->toggleModal();
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.order.modal.billing-type');
    }
}
