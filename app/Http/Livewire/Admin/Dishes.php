<?php

namespace App\Http\Livewire\Admin;

use App\Models\Dish;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class Dishes extends Component
{
    use WithPagination;

    public $category;
    public $categories;
    public $pages = 10;

    protected $queryString = [
        'category' => ['except' => ''],
    ];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function deactivate(Dish $dish)
    {
        $dish->status = '0';
        $dish->save();
        session()->flash('message', 'Dish successfully deactivated');
    }

    public function restore(Dish $dish)
    {
        $dish->status = '1';
        $dish->save();
        session()->flash('message', 'Dish successfully restored');

    }

    public function render()
    {
        $category = $this->category;
        $pages = $this->pages != "All" ? $this->pages : Dish::all()->count();
        return view('livewire.admin.dishes', [
            'dishes' => Dish::when($category != 0, function($query) use ($category){
                    return $query->whereHas('category', function($query) use ($category) {
                        $query->where('id' , $category);
                    });
                })
                ->orderBy('name')
                ->paginate($pages)
            ]
        );
    }
}
