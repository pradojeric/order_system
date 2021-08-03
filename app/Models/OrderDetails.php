<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'side_dishes' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function cancel()
    {
        return $this->morphMany(Cancel::class, 'cancellable');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function scopeDrinks($query)
    {
        return $query->whereHas('dish', function ($dish){
            $dish->whereHas('category', function($category){
                $category->where('type', 'drinks');
            });
        });
    }

    public function isDrink()
    {
        return $this->dish->category->type == "alcoholic";
    }

    public function isFood()
    {
        return $this->dish->category->type == "foods";
    }
}
