<?php

namespace App\Http\Livewire\Order;

use App\Models\Dish;
use App\Models\Order;
use Livewire\Component;
use App\Models\Category;
use App\Models\CustomDish;
use App\Models\OrderDetails;
use App\Events\OrderUpdatedEvent;

class Details extends Component
{
    public $action;
    public $table;
    public $categories;
    public $dishes;
    public $sideDishes = [];
    public $orderedDishes = [];
    public $selectedCategory = 1;
    public $totalPrice = 0;
    public $oldOrders = [];
    public $oldCustomOrders = [];
    public $order;
    public $isReviewing;

    protected $listeners = [
        'addToDish' => 'addCustomDish',
        'void' => 'void',
        'addSideDish' => 'addDish',
        'cancelReview' => 'setReview',
    ];

    protected $rules = [
        'dishes.*.quantity' => 'required|numeric',
        'dishes.*.name' => 'required',
        'dishes.*.side' => 'nullable'
    ];

    public function mount()
    {
        $this->isReviewing = false;
        $this->categories = Category::all();
        $dishes = Category::find(1)->dishes->sortBy('name');
        $this->dishes = $dishes->each(function ($dish) {
            $dish['quantity'] = 1;
        });
        if ($this->order) {
            $this->oldOrders = $this->order->orderDetails;
            $this->oldCustomOrders = $this->order->customOrderDetails;
        }
    }

    public function setReview()
    {
        $this->isReviewing = false;
    }

    public function void($itemId, $isCustom)
    {
        if ($isCustom == false) {
            $item = OrderDetails::findOrFail($itemId);
        } else {
            $item = CustomDish::findOrFail($itemId);
        }
        $item->delete();
        event(new OrderUpdatedEvent());
        if ($this->order) {
            $order = Order::findOrFail($this->order->id);
            $this->oldOrders = $order->orderDetails;
            $this->oldCustomOrders = $order->customOrderDetails;
        }
        //
    }

    public function viewDishes($categoryId = null)
    {
        $this->dishes = [];
        $this->sideDishes = [];
        if ($categoryId) {
            $this->selectedCategory = $categoryId;
            $category = Category::find($categoryId);
            $dishes = $category->dishes->sortBy('name');
            $this->dishes = $dishes->each(function ($dish) {
                $dish['quantity'] = 1;
            });
            if($category->add_on)
            {
                $this->sideDishes = Dish::sideDish()->get();
            }
        }
    }

    public function incrementQuantity($index)
    {
        $this->dishes[$index]['quantity'] += 1;
    }

    public function decrementQuantity($index)
    {
        if ($this->dishes[$index]['quantity'] > 1)
            $this->dishes[$index]['quantity'] -= 1;
    }

    public function addDish(Dish $dish, $quantity, $side = null)
    {
        if (!$dish->status) return;
        $sideDish = Dish::find($side);
        $newDish = [];
        foreach ($this->orderedDishes as $i => $d) {
            if (array_key_exists('id', $d)) {
                if ( $d['id'] == $dish->id && ($d['side_id'] == null || $d['side_id'] == $sideDish->id) ) {
                    $d['quantity'] += $quantity;
                    $d['price'] = $d['quantity'] * $dish->price;
                    $newDish[$i] = $d;
                }
            }
        }
        if (count($newDish) > 0) {
            $this->orderedDishes = $newDish + $this->orderedDishes;
        } else {
            $this->orderedDishes[] = [
                'id' => $dish->id,
                'name' => $dish->name,
                'price' => $dish->price * $quantity,
                'quantity' => $quantity,
                'side_id' => $sideDish->id ?? null,
                'side_name' => $sideDish->name ?? null,
            ];
        }

        $this->total();
    }

    public function addCustomDish($customDish)
    {
        if (!$customDish) return;

        $this->orderedDishes[] = [
            'name' => $customDish['name'],
            'price' => $customDish['price'] * $customDish['pcs'],
            'desc' => $customDish['desc'],
            'quantity' => $customDish['pcs'],
            'type' => $customDish['type'],
        ];

        $this->total();
    }

    public function removeDish($index)
    {
        unset($this->orderedDishes[$index]);
        $this->orderedDishes = array_values($this->orderedDishes);
        $this->total();
    }

    public function total()
    {
        $this->totalPrice = 0;
        foreach ($this->orderedDishes as $d) {
            $this->totalPrice += $d['price'];
        }
    }

    public function placeOrders()
    {
        $this->isReviewing = true;
        $this->emitTo('order.review', 'fillOrder', $this->orderedDishes);
    }

    public function render()
    {
        return view('livewire.order.details');
    }
}
