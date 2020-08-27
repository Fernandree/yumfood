<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dishes')->insert([
            [
                'name' => "Nigerian Jollof Rice and Chicken",
                'price' => "100",
            ],
            [
                'name' => "Burger and Coke",
                'price' => "50",
            ],
            [
                'name' => "Chicken and Chips",
                'price' => "30",
            ],
            [
                'name' => "Ghana Jollof Rice and Water",
                'price' => "5",
            ],
            [
                'name' => "Cheese Pizza",
                'price' => "15",
            ],
            [
                'name' => "Hamburger",
                'price' => "10",
            ],
            [
                'name' => "Cheeseburger",
                'price' => "10",
            ],
            [
                'name' => "Bacon Burger",
                'price' => "15",
            ],
            [
                'name' => "Bacon Cheeseburger",
                'price' => "18",
            ],
            [
                'name' => "Sushi",
                'price' => "10",
            ],
            [
                'name' => "Kimbab",
                'price' => "10",
            ],
            [
                'name' => "Spicy Noodle",
                'price' => "12",
            ],
            [
                'name' => "Fish and Chips",
                'price' => "20",
            ],
            [
                'name' => "Okonomiyaki",
                'price' => "10",
            ],
            [
                'name' => "Ramen",
                'price' => "12",
            ],
            [
                'name' => "Salmon Aburi",
                'price' => "20",
            ],
            [
                'name' => "Spaghetti",
                'price' => "10",
            ],
            [
                'name' => "Takoyaki",
                'price' => "10",
            ],
            [
                'name' => "Meatball",
                'price' => "10",
            ],
            [
                'name' => "Spaghetti Aglio Olio",
                'price' => "15",
            ],
        ]);
    }
}
