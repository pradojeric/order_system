<?php

namespace App\Http\Livewire\Order\Modal;

use App\Models\Dish;
use App\Models\Category;
use App\Http\Livewire\Modal;

class AddOn extends Modal
{

    public $addOns = [];
    public $sideDish;
    public $dish;
    public $quantity;

    protected $listeners = [
        'addOn' => 'addOn'
    ];

    protected $rules = [
        'sideDish' => 'required'
    ];

    protected $messages = [
        'sideDish.required' => 'Please choose one side dish'
    ];

    public function mount()
    {
        $this->addOns = Dish::sideDish()->get();
    }

    public function addOn(Dish $dish, $quantity)
    {
        if (!$dish->status) return;
        $this->toggleModal();
        $this->dish = $dish;
        $this->quantity = $quantity;
    }

    public function addToOrder()
    {
        $this->validate();

        $this->emitTo('order.details', 'addSideDish', $this->dish, $this->quantity, $this->sideDish);
        $this->reset('sideDish', 'dish', 'quantity');
        $this->close();
    }

    public function close()
    {
        $this->resetValidation();
        $this->toggleModal();
    }

    public function render()
    {
        return view('livewire.order.modal.add-on');
    }
}
