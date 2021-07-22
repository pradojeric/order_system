<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\Modal;
use App\Models\Configuration;
use App\Events\OrderUpdatedEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Review extends Modal
{
    use AuthorizesRequests;

    public $config;
    public $order;
    public $table;
    public $orderDetails;
    public $totalPrice;
    public $pax;
    public $action;
    public $address;
    public $contact;

    protected $listeners = [
        'fillOrder' => 'fillOrder',
        'close' => 'close',
    ];

    public function mount()
    {
        $this->pax = $this->order->pax ?? '';
        $this->config = Configuration::get()->first();

    }

    protected $rules = [
        'orderDetails' => 'array|required',
        'orderDetails.*' => 'required',
    ];

    protected $messages = [
        'orderDetails.required' => 'You must have at least one order.',
    ];

    public function close()
    {
        $this->emitTo('order.details', 'cancelReview');
        $this->resetValidation();
        $this->toggleModal();
    }

    public function fillOrder($orderedDishes)
    {
        $this->isModalOpen = true;
        $this->orderDetails = $orderedDishes;
        $this->totalPrice = 0;
        foreach ($this->orderDetails as $d) {
            $this->totalPrice += $d['price'];
        }
    }

    public function updated()
    {
        $this->resetValidation();
        if ($this->pax < 1) {
            $this->addError('pax', 'You must enter a number of person');
        }
        if ($this->action === 'Delivery') {
            if ($this->address === '' || empty($this->address)) {
                $this->addError('address', 'You must enter address');
            }

            if ($this->contact === '' || empty($this->contact)) {
                $this->addError('contact', 'You must enter contact');
            }
        }
    }

    public function createOrder()
    {

        if ($this->action === 'Delivery') {
            if ($this->address === '' || empty($this->address)) {
                $this->addError('address', 'You must enter address');
                return;
            }

            if ($this->contact === '' || empty($this->contact)) {
                $this->addError('contact', 'You must enter contact');
                return;
            }
        }
        if ($this->pax < 1) {
            $this->addError('pax', 'You must enter a number of person');
            return;
        }
        $this->validate();

        $orderDetails = [];
        $customDishes = [];
        foreach ($this->orderDetails as $item) {
            if (array_key_exists('id', $item)) {
                if($item['side_id']){
                    $sideDishes = [
                        'side_id' => $item['side_id'],
                        'side_name' => $item['side_name'],
                    ];
                }

                $orderDetails[] = [
                    'dish_id' => $item['id'],
                    'pcs' => $item['quantity'],
                    'price' => $item['price'],
                    'side_dishes' => $sideDishes ?? null,
                ];
            } else {
                $customDishes[] = [
                    'name' => str_replace("(Custom)", "", $item['name']),
                    'pcs' => $item['quantity'],
                    'description' => $item['desc'],
                    'price' => $item['price'],
                    'type' => $item['type'],
                ];
            }
        }

        if (!$this->order) {
            $this->order = Auth::user()->orders()->create([
                'order_number' => $this->config->order_no,
                'pax' => $this->pax,
                'action' => $this->action,
                'address' => $this->address,
                'contact' => $this->contact,
            ]);
            if ($this->table) {
                $this->order->tables()->sync($this->table);
            }
        } else {
            $this->order->update([
                'pax' => $this->pax,
            ]);
        }

        $this->order->orderDetails()->createMany($orderDetails);

        if (count($customDishes) > 0) {
            $this->order->customOrderDetails()->createMany($customDishes);
        }

        $this->config->increment('order_no');

        $this->dispatchBrowserEvent('printOrder', ['orderId' => $this->order->id]);

        event(new OrderUpdatedEvent());

        // return redirect()->to('/waiter-order');
    }



    public function render()
    {
        return view('livewire.order.review');
    }
}
