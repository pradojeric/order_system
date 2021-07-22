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
                'description' => 'Appetizer',
                'type' => 'foods',
                'icon' => 'icons/Appetizer.png',
            ],
            [
                'name' => 'Soup',
                'description' => 'Soup',
                'type' => 'foods',
                'icon' => 'icons/Soup.png',
            ],
            [
                'name' => 'Salad',
                'description' => 'Salad',
                'type' => 'foods',
                'icon' => 'icons/Salad.png',
            ],
            [
                'name' => 'Sandwiches',
                'description' => 'Sandwiches',
                'type' => 'foods',
                'icon' => 'icons/Sandwich.png',
            ],
            [
                'name' => 'Mains',
                'description' => 'Mains',
                'type' => 'foods',
                'icon' => 'icons/Main.png',
            ],
            [
                'name' => 'Sides',
                'description' => 'Sides',
                'type' => 'foods',
                'icon' => 'icons/Side.png',
            ],
            [
                'name' => 'Pasta',
                'description' => 'Pasta',
                'type' => 'foods',
                'icon' => 'icons/Pasta.png',
            ],
            [
                'name' => 'Non-alcoholic',
                'description' => 'Non-alcoholic',
                'type' => 'drinks',
                'icon' => 'icons/Non-alcoholic.png',
            ],
            [
                'name' => 'Alcoholic',
                'description' => 'Alcoholic',
                'type' => 'drinks',
                'icon' => 'icons/Alcoholic.png',
            ],
        ];

        Category::insert($menus);

        $dishes = [
            //Appetizer
            [
                'category_id' => 1,
                'name' => 'BBQ Shrimp',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 1,
                'name' => 'Spinach Artichoke',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 1,
                'name' => 'Leffe/Cheese Dip',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            //Soup
            [
                'category_id' => 2,
                'name' => 'Tomato Basil',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 2,
                'name' => 'Shrimp and Crab Bisque',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 2,
                'name' => 'Smoked Potato and Steak Soup',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            //Salad
            [
                'category_id' => 3,
                'name' => 'Summer',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 3,
                'name' => 'Ceasar',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 3,
                'name' => 'Wedge',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            //Sandwiches
            [
                'category_id' => 4,
                'name' => 'Bleu Cheese Burger',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 4,
                'name' => 'Bacon Burger',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 4,
                'name' => 'Philly Cheesesteak',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            //Mains
            [
                'category_id' => 5,
                'name' => 'Steak',
                'description' => 'Description',
                'add_on' => true,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 5,
                'name' => 'Salmon',
                'description' => 'Description',
                'add_on' => true,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 5,
                'name' => 'Chicken',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 5,
                'name' => 'Meatloaf',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            //Sides
            [
                'category_id' => 6,
                'name' => 'Mashed Potato',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 150,
            ],
            [
                'category_id' => 6,
                'name' => 'Herbed Fries',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 150,
            ],
            [
                'category_id' => 6,
                'name' => 'Mac and Cheese',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 150,
            ],
            [
                'category_id' => 6,
                'name' => 'Baked Potato',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 150,
            ],
            //Pasta
            [
                'category_id' => 7,
                'name' => 'Pesto',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 7,
                'name' => 'Spag and Meatball',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 7,
                'name' => 'Shrimp Scampi',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            //Non-alocholic Drinks
            [
                'category_id' => 8,
                'name' => 'Coke',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 8,
                'name' => 'Lemonade',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 8,
                'name' => 'Iced Tea',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 8,
                'name' => 'Sprite',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 8,
                'name' => 'Milk',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            [
                'category_id' => 8,
                'name' => 'Chocolate Milk',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 150,
            ],
            //Alcoholic
            [
                'category_id' => 9,
                'name' => 'Well Tequila',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
        ];

        Dish::insert($dishes);
    }
}
