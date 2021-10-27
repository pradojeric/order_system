<?php

namespace App\Http\Livewire\Order\Table;

use App\Events\AnyOrderUpdatedEvent;
use App\Events\OrderUpdatedEvent;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Orders extends Component
{
    use AuthorizesRequests;

    public $message = '';
    public $enableDiscount;
    public $enableServiceCharge;
    public $discountType;
    public $discount;
    public $action;
    public $order;
    public $isSaved;
    public $billingType;

    protected $rules = [
        'enableDiscount' => 'nullable',
        'discountType' => 'nullable|required_if:enable_discount,true|in:percent,fixed',
        'discount' => 'required_if:enable_discount,true|numeric|min:1',
    ];

    public function mount()
    {
        $this->resetDiscount();
    }

    public function getListeners()
    {
        $listeners = [
            'echo:newOrder,AnyOrderUpdatedEvent' => 'resetDiscount',
        ];
        if($this->order) {
            $listeners["echo:updatedOrder.{$this->order->id},OrderUpdatedEvent"] = 'resetDiscount';
            $listeners["voidOrder.{$this->order->id}"] = 'void';
        }
        return $listeners;
    }

    public function resetDiscount()
    {
        $this->isSaved = false;
        $this->billingType = 'single';
        $this->enableDiscount = false;
        $this->discountType = 'percent';
        $this->discount = 0;
        if ($this->order) {
            $this->enableDiscount = $this->order->enable_discount;
            $this->discountType = $this->order->discount_type;
            $this->discount = $this->order->discount;
            $this->enableServiceCharge = !$this->order->enable_tip;
        }
    }

    public function void($itemId, $isCustom)
    {
        $this->authorize('manage');

        $item = Order::find($itemId);
        if ($item == null) return;

        $item->cancel()->create([
            'waiter_id' => $item->waiter_id,
            'reason' => 'Order voided',
        ]);

        $item->tables()->detach();

        $item->delete();

        event(new AnyOrderUpdatedEvent());
        //
    }

    public function setBillingType()
    {
        if($this->billingType == "single"){
            $this->billingType = "multiple";
            return;
        }

        if($this->billingType == "multiple") {
            $this->billingType = "single";
            return;
        }
    }

    public function activateDiscount()
    {
        $this->reset('isSaved');
        $this->enableDiscount = !$this->enableDiscount;

        if (!$this->enableDiscount) {
            $this->order->update([
                'enable_discount' => $this->enableDiscount,
            ]);
            $this->callEvent();
        }
    }

    public function discountSave()
    {
        $this->reset('isSaved');
        $this->validate();

        $this->order->update([
            'enable_discount' => $this->enableDiscount,
            'discount_type' => $this->discountType,
            'discount' => $this->discount,
        ]);

        $this->isSaved = true;
        $this->callEvent();
    }

    public function updatingEnableServiceCharge($value)
    {
        $this->order->enable_tip = !$value;
        $this->order->save();
    }


    public function callEvent()
    {
        event(new OrderUpdatedEvent($this->order));
    }
}
