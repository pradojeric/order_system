<?php

namespace App\Http\Livewire\Order;

use App\Models\Dish;
use App\Models\Order;
use Livewire\Component;
use App\Models\Category;
use App\Models\Configuration;
use App\Events\PrintKitchenEvent;
use Illuminate\Support\Facades\DB;
use App\Events\AnyOrderUpdatedEvent;
use Illuminate\Support\Facades\Auth;

class DetailsNew extends Component
{

    public $action;
    public $table;
    public $categories;
    public $dishes;
    public $sideDishes = [];
    public $orderedDishes = [];
    public $customDishes = [];
    public $selectedCategory = 1;
    public $totalPrice = 0;
    public $pax = null;

    public $oldOrders = [];
    public $oldCustomOrders = [];
    public $order;

    public $address;
    public $contact;

    public $config;

    protected $listeners = [
        'createOrder'
    ];

    public function mount(Order $order = null)
    {
        $this->config = Configuration::get()->first();

        $this->order = $order;
        $this->isReviewing = false;
        $this->sideDishes = Dish::sideDish()->get();
        $this->categories = Category::all();
        $dishes = Dish::orderBy('name')->get();
        $this->dishes = $dishes->each(function ($dish) {
            $dish['quantity'] = 1;
        })->toArray();

        if ($this->order->getAttributes()) {
            $this->oldOrders = $this->order->orderDetails;
            $this->oldCustomOrders = $this->order->customOrderDetails;
            $this->pax = $this->order->pax;
        }
    }

    public function createOrder()
    {


        DB::transaction(function () {

            if ($this->order->getAttributes() == null) {

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

            $orderDetails = [];
            $customDishes = [];

            try {
                foreach ($this->orderedDishes as $item) {
                    if (array_key_exists('id', $item)) {

                        $orderDetails = $this->order->orderDetails()->create( [
                            'dish_id' => $item['id'],
                            'pcs' => $item['quantity'],
                            'price' => $item['price'] * $item['quantity'],
                            'price_per_piece' => $item['price'],
                            'note' => $item['note'],
                            'printed' => 0,
                        ]);

                        if(array_key_exists('sideDishes', $item) && $item['sideDishes'] != null)
                        {
                            foreach($item['sideDishes'] as $side)
                            {
                                $orderDetails->sideDishes()->create([
                                    'side_dish_id' => $side['id']
                                ]);
                            }
                        }

                    } else {
                        $customDishes[] = [
                            'name' => str_replace("(Custom)", "", $item['name']),
                            'pcs' => $item['quantity'],
                            'description' => $item['desc'],
                            'price' => $item['price'],
                            'price_per_piece' => $item['price_per_piece'],
                            'type' => $item['type'],
                            'printed' => 0,
                        ];
                    }
                }

                if (count($customDishes) > 0) {
                    $this->order->customOrderDetails()->createMany($customDishes);
                }

                $this->config->increment('order_no');
                DB::commit();
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollBack();
            }

        });

        event(new AnyOrderUpdatedEvent());
        // event(new PrintKitchenEvent($this->order));
        $this->dispatchBrowserEvent('printOrder', ['orderId' => $this->order->id]);
    }

    public function render()
    {
        return view('livewire.order.details-new');
    }
}
