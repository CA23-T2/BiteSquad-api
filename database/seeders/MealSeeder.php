<?php

namespace Database\Seeders;

use App\Models\MealCategory;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meal;
use Faker\Factory as Faker;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $categories = ['Topla jela', 'Dezerti', 'Salate', 'Hladna jela', 'Brza hrana'];

        for ($i = 1; $i <= 5; $i++) {

            $faker = Faker::create();


            MealCategory::create([
                "name" => $categories[$i - 1],
                "description" => $faker->sentence,
            ]);
        }

        for ($i = 1; $i <= 50; $i++) {

            $faker = Faker::create();


            $meal = new Meal([
                "meal_name" => implode(' ', $faker->words(3)),
                "description" => $faker->sentence,
                "price" => $faker->randomFloat(2, 0.01, 29.99),
                "image_url" => '/512x512.svg',
                "dietary_restrictions" => implode(', ', $faker->words(5))
            ]);

            $meal->category()->associate(random_int(1,5));
            $meal->save();


        }
    }
}
