<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\Order\Table\Discount;

class OtherTable extends Discount
{
    public function render()
    {
        return view('livewire.order.other-table');
    }
}
