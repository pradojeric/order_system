<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    /**
     * Get all of the orderDetails for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function customOrderDetails()
    {
        return $this->hasMany(CustomDish::class);
    }

    public function orderReceipts()
    {
        return $this->hasMany(OrderReceipt::class);
    }

    public function cancel()
    {
        return $this->morphMany(Cancel::class, 'cancellable');
    }

    public function orderDishes()
    {
        $orders = $this->orderDetails->groupBy('dish_id');

        $dishes = Dish::all();

        $normalOrders = $orders->map(function ($item) use ($dishes) {
            $dish_id = $item->first()['dish_id'];
            return [
                'dish_name' => $dishes->where('id', $dish_id)->first()->name,
                'qty' => $item->sum('pcs')
            ];
        })->toArray();
        $customOrders = $this->customOrderDetails->map(function ($item) {
            return [
                'dish_name' => $item->name,
                'qty' => $item->pcs
            ];
        })->toArray();

        return array_merge($normalOrders, $customOrders);
    }

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    public function isCheck()
    {
        return $this->attributes['ref_no'] != null;
    }

    public function totalPrice()
    {
        // $total =  $this->totalPriceWithoutDiscount();

        // if ($this->enable_discount == true) {
        //     if ($this->discount_type === 'percent') {
        //         $total = $total - ($total * $this->discount / 100);
        //     }

        //     if ($this->discount_type === 'fixed') {
        //         $total = $total - $this->discount;
        //     }
        // }

        // return $total;
        if($this->enable_discount){
            if($this->discount_settings == 'whole')
            {
                $total =  $this->totalPriceWithoutDiscount();

                if ($this->discount_type === 'percent') {
                    $total = $total - ($total * $this->discount / 100);
                }

                if ($this->discount_type === 'fixed') {
                    $total = $total - $this->discount;
                }

                return $total;
            }

            if($this->discount_settings == 'per_item')
            {
                $customPrices = $this->customOrderDetails->sum(function($item){
                    return $item->getPrice();
                });
                $orderPrices = $this->orderDetails->sum(function($item){
                    return $item->getPrice();
                });
            }



            return $customPrices + $orderPrices;
        }

        return $this->totalPriceWithoutDiscount();

    }

    public function totalPriceWithServiceCharge()
    {
        return $this->totalPrice() + $this->serviceCharge();
    }

    public function totalPriceWithoutDiscount()
    {
        $customPrices = $this->customOrderDetails->sum('price');
        $orderPrices = $this->orderDetails->sum('price');

        $totalPrice = $orderPrices + $customPrices;

        return $totalPrice;
    }

    public function totalDiscountedPrice()
    {
        return $this->totalPriceWithoutDiscount() - $this->totalPrice();
    }

    public function serviceCharge()
    {
        $config = Configuration::first();

        if($this->enable_tip) {
            if($this->action == "Dine In")
                return $this->totalPrice() * ($config->tip / 100);
            else
                return $config->take_out_charge;
        }
        return 0;
    }

    public function serviceChargeFromDB()
    {
        // $config = Configuration::first();
        // return $this->totalPrice() * ($config->tip / 100);
        if($this->enable_tip) {
            if($this->action == "Dine In")
                return $this->totalPrice() * ($this->tip / 100);
            else
                return $this->take_out_charge;
        }
        return 0;
    }

    public function getDiscountOptionAttribute()
    {
        $discount = '';
        if ($this->enable_discount) {

            $discount = number_format($this->discount, 2, '.', ',');
            $discount = number_format($this->totalDiscountedPrice(), 2, '.', ',');

        } else {
            $discount = '-';
        }
        return $discount;
    }

    public function tables()
    {
        return $this->belongsToMany(Table::class);
    }

    public function table()
    {
        return $this->tables->first();
    }
}
