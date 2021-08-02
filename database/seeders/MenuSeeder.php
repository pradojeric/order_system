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
                'name' => 'Desserts',
                'description' => 'Desserts',
                'type' => 'foods',
                'icon' => 'icons/Dessert.png',
            ],
            [
                'name' => 'LCR Classics',
                'description' => 'LCR Classics',
                'type' => 'foods',
                'icon' => 'icons/Classic.png',
            ],
            [
                'name' => 'Kids Menu',
                'description' => 'Kids Menu',
                'type' => 'foods',
                'icon' => 'icons/Kids.png',
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
                'name' => 'Sisig Nacho',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 350,
            ],
            [
                'category_id' => 1,
                'name' => 'Charcuterie Board',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 1,
                'name' => 'Spinach Artichoke',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 315,
            ],
            [
                'category_id' => 1,
                'name' => 'Bacon Wrapped BBQ Shrimp',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 245,
            ],
            [
                'category_id' => 1,
                'name' => 'Crabcakes',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 1,
                'name' => 'Fried Pickles',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            //Soup
            [
                'category_id' => 2,
                'name' => 'Tomato Soup',
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
                'price' => 180,
            ],
            [
                'category_id' => 2,
                'name' => 'Potato and Steak Soup',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 195,
            ],
            //Salad
            [
                'category_id' => 3,
                'name' => 'Summer Salad',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 275,
            ],
            [
                'category_id' => 3,
                'name' => 'Ceasar Salad',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 245,
            ],
            [
                'category_id' => 3,
                'name' => 'Wedge',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 240,
            ],
            //Sandwiches
            [
                'category_id' => 4,
                'name' => 'Bleu Cheese Burger',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 315,
            ],
            [
                'category_id' => 4,
                'name' => 'Bacon Burger',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 275,
            ],
            [
                'category_id' => 4,
                'name' => 'Loaded Grilled Cheese',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 250,
            ],
            [
                'category_id' => 4,
                'name' => 'Sriracha Chicken Sandwich',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 4,
                'name' => 'Grilled Vegetable Wrap',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 4,
                'name' => 'Philly Cheesesteak',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            //Mains
            [
                'category_id' => 5,
                'name' => 'Hickory Bourbon Steak',
                'description' => 'Description',
                'add_on' => true,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 5,
                'name' => 'Almond Encrusted Salmon',
                'description' => 'Description',
                'add_on' => true,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 5,
                'name' => 'Chicken Fried Chicken',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 5,
                'name' => 'Meltique Ribeye',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 5,
                'name' => 'Australian TBone',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 5,
                'name' => 'Salmon Oscar',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 5,
                'name' => 'Meatloaf',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            //Sides
            [
                'category_id' => 6,
                'name' => 'Mashed Potato',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 9999,
            ],
            [
                'category_id' => 6,
                'name' => 'Herbed Fries',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 9999,
            ],
            [
                'category_id' => 6,
                'name' => 'Mac and Cheese',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 9999,
            ],
            [
                'category_id' => 6,
                'name' => 'Baked Potato',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 9999,
            ],
            [
                'category_id' => 6,
                'name' => 'Rice Pilaf',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 9999,
            ],
            [
                'category_id' => 6,
                'name' => 'Grilled Seasonal Veggies',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 9999,
            ],
            [
                'category_id' => 6,
                'name' => 'Baked Sweet Potato',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 9999,
            ],
            [
                'category_id' => 6,
                'name' => 'Green Bean Casserole',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 9999,
            ],
            [
                'category_id' => 6,
                'name' => 'Asparagus',
                'description' => 'Description',
                'add_on' => false,
                'sides' => true,
                'price' => 9999,
            ],
            //Pasta
            [
                'category_id' => 7,
                'name' => 'Pesto',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 275,
            ],
            [
                'category_id' => 7,
                'name' => 'Spaghetti and Meatballs',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 7,
                'name' => 'Shrimp Scampi',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 7,
                'name' => 'Creamy Mushroom Pasta',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            //Desserts
            [
                'category_id' => 8,
                'name' => 'Fruit Granola Parfait',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 8,
                'name' => 'St Louis Butter Cake',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 8,
                'name' => 'Chocolate Mousse',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 8,
                'name' => 'Banana Foster',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 8,
                'name' => 'Quadruple Chocolate Cake',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 8,
                'name' => 'Bread Pudding',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            //LCR Classics
            [
                'category_id' => 9,
                'name' => 'Sabina Rice',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 130,
            ],
            [
                'category_id' => 9,
                'name' => 'Sabina Rice',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 260,
            ],
            [
                'category_id' => 9,
                'name' => 'Sisig Banana Blossom',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 9,
                'name' => 'Seafood Paella',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 9,
                'name' => 'Korean Beef',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 9,
                'name' => 'Pancit Bihon-Guisado',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 9,
                'name' => 'Bangus Sisig',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            //Kids Menu
            [
                'category_id' => 10,
                'name' => 'Chicken Tenders with Fries',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 10,
                'name' => 'Filipino Spaghetti and Meatballs',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            [
                'category_id' => 10,
                'name' => 'Cheeseburger Slider with Fries',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 9999,
            ],
            //Non-alocholic Drinks
            [
                'category_id' => 11,
                'name' => 'Coke',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 60,
            ],
            [
                'category_id' => 11,
                'name' => 'Lemonade',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 30,
            ],
            [
                'category_id' => 11,
                'name' => 'Nestea Iced Tea',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 75,
            ],
            [
                'category_id' => 11,
                'name' => 'Coke Zero',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 60,
            ],
            [
                'category_id' => 11,
                'name' => 'Sprite',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 60,
            ],
            [
                'category_id' => 11,
                'name' => 'Royal',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 60,
            ],
            [
                'category_id' => 11,
                'name' => 'Mtn Dew',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 60,
            ],
            [
                'category_id' => 11,
                'name' => 'Milk',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 50,
            ],
            [
                'category_id' => 11,
                'name' => 'Chocolate Milk',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 50,
            ],
            [
                'category_id' => 11,
                'name' => 'Pinapple Juice',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 50,
            ],
            [
                'category_id' => 11,
                'name' => 'Orange Juice',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 50,
            ],
            //Alcoholic
            [
                'category_id' => 12,
                'name' => 'Bloody Mary',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
            [
                'category_id' => 12,
                'name' => 'Moscow Mule',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
            [
                'category_id' => 12,
                'name' => 'Margarita',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
            [
                'category_id' => 12,
                'name' => 'Mojito',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
            [
                'category_id' => 12,
                'name' => 'Long Island',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
            [
                'category_id' => 12,
                'name' => 'Mini Ocean',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
            [
                'category_id' => 12,
                'name' => 'Old Fashioned',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
            [
                'category_id' => 12,
                'name' => 'Martini',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
            [
                'category_id' => 12,
                'name' => 'Cosmopolitan',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
            [
                'category_id' => 12,
                'name' => 'Whiskey Sour',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],
            [
                'category_id' => 12,
                'name' => 'Oasis',
                'description' => 'Description',
                'add_on' => false,
                'sides' => false,
                'price' => 25,
            ],

        ];

        Dish::insert($dishes);
    }
}
