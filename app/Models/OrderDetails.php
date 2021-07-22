<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'side_dishes' => 'array'
    ];

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
        return $this->dish->category->type == "drinks";
    }
}
