<?php

namespace App\Http\Livewire\Order\Modal;

use App\Models\Order;
use App\Http\Livewire\Modal;
use App\Events\OrderUpdatedEvent;

class Discount extends Modal
{
    public Order $order;

    public $enableDiscount;
    public $discountType;
    public $discount;
    public $discountDescription;

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function getListeners()
    {
        return [
            "openDiscount.{$this->order->id}" => 'openDiscount',
            'echo:newOrder,AnyOrderUpdatedEvent' => '$refresh',
        ];
    }

    public function openDiscount()
    {
        $this->enableDiscount = $this->order->enable_discount;
        $this->discountType = $this->order->discount_type;
        $this->discount = $this->order->discount;
        $this->discountDescription = $this->order->discount_ref;
        $this->toggleModal();
    }

    public function saveDiscount()
    {
        $this->order->update([
            'enable_discount' => $this->enableDiscount ?? false,
            'discount_type' => $this->enableDiscount ? $this->discountType : 'percent',
            'discount' => $this->enableDiscount ? $this->discount : null,
            'discount_ref' => $this->enableDiscount ? $this->discountDescription : null,
        ]);

        event(new OrderUpdatedEvent($this->order));

        $this->close();
    }

    public function close()
    {
        $this->toggleModal();
    }

    public function render()
    {
        return view('livewire.order.modal.discount');
    }
}
