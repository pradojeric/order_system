<?php

namespace App\Http\Livewire\Order\Table;

use App\Events\OrderUpdatedEvent;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Discount extends Component
{
    use AuthorizesRequests;

    public $enableDiscount;
    public $discountType;
    public $discount;
    public $action;
    public $order;
    public $isSaved;
    public $billingType;

    protected $rules = [
        'enableDiscount' => 'nullable',
        'discountType' => 'nullable|required_if:enable_discount,true|in:percent,fixed',
        'discount' => 'required_if:enable_discount,true|numeric|min:1'
    ];

    protected $listeners = [
        'void' => 'void',
        'echo:updatedOrder,OrderUpdatedEvent' => '$refresh'
    ];

    public function mount()
    {
        $this->isSaved = false;
        $this->billingType = 'single';
        if ($this->order) {
            $this->enableDiscount = $this->order->enable_discount;
            $this->discountType = $this->order->discount_type;
            $this->discount = $this->order->discount;
        }
    }

    public function void($itemId, $isCustom)
    {
        $this->authorize('manage');

        $item = Order::find($itemId);
        if ($item == null) return;
        foreach ($item->orderDetails as $detail) {
            $detail->delete();
        }
        foreach ($item->customOrderDetails as $detail) {
            $detail->delete();
        }
        $item->delete();
        $this->callEvent();
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
        }
        $this->callEvent();
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

    public function callEvent()
    {
        event(new OrderUpdatedEvent());
    }
}
