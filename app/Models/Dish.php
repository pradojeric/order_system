<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dish extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSideDish($query)
    {
        return $query->where('sides', true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

    public function getPriceFormattedAttribute()
    {
        return "₱ " . number_format($this->price, 2, '.', ',');
    }
}
