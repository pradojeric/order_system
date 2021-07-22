<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Dish;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name' => 'Appetizer',
                'description' => 'Appetizer dish',
                'type' => 'foods',
                'icon' => 'icons/Appetizer.png',
            ],
            [
                'name' => 'Dessert',
                'description' => 'Dessert dish',
                'type' => 'foods',
                'icon' => 'icons/Dessert.png',
            ],
            [
                'name' => 'Alcoholic',
                'description' => 'Alcoholic Drinks',
                'type' => 'drinks',
                'icon' => 'icons/Alcoholic.png',
            ],
            [
                'name' => 'Non-Alcoholic',
                'description' => 'Non-alcoholic Drinks',
                'type' => 'drinks',
                'icon' => 'icons/Non-alcoholic.png',
            ],
            [
                'name' => 'Mains',
                'description' => 'Main dish',
                'type' => 'foods',
                'icon' => 'icons/Menu.png',
            ],
            [
                'name' => 'Salad',
                'description' => 'Salad dish',
                'type' => 'foods',
                'icon' => 'icons/Salad.png',
            ],
            [
                'name' => 'Sides',
                'description' => 'Side dish',
                'type' => 'foods',
                'icon' => 'icons/Side-Dish.png',
            ]
        ];

        Category::insert($menus);

        $dishes = [
            [
                'category_id' => 1,
                'name' => 'Seafood Paela',
                'description' => 'Description Here',
                'price' => 490,
            ],
            [
                'category_id' => 3,
                'name' => 'Iced Tea',
                'description' => 'Description Here',
                'price' => 120,
            ],
            [
                'category_id' => 4,
                'name' => 'Bangus Sisig Rice Bowl',
                'description' => 'Description Here',
                'price' => 130,
            ],
            [
                'category_id' => 4,
                'name' => 'Sabina Rice Bowl',
                'description' => 'Description Here',
                'price' => 130,
            ],
            [
                'category_id' => 4,
                'name' => 'Chicek Pork Adobo Rice Bowl',
                'description' => 'Description Here',
                'price' => 130,
            ],
        ];

        Dish::insert($dishes);
    }
}
