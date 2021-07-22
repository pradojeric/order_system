<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\Order\Table\Discount;
use App\Models\Order;

class Table extends Discount
{

    public $table;
    public $hasOrder;

    public function render()
    {
        $this->order = $this->table->order();
        $this->hasOrder = $this->table->order() ? true : false;

        return view('livewire.order.table');
    }
}
