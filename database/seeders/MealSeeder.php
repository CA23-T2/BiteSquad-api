<?php

namespace Database\Seeders;

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
        for ($i = 1; $i <= 50; $i++) {

            $faker = Faker::create();

            Meal::create([
                "meal_name" => implode(' ', $faker->words(3)),
                "description" => $faker->sentence,
                "price" => $faker->randomFloat(2, 0.01, 29.99),
                "image_url" => "https://fakeimg.pl/600x400",
                "dietary_restrictions" => implode(', ', $faker->words(5))
            ]);
        }
    }
}
