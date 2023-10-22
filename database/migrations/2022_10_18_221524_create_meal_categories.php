<?php

use App\Models\MealCategory;
use Faker\Factory as Faker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meal_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        $categories = ['Topla jela', 'Dezerti', 'Salate', 'Hladna jela', 'Brza hrana'];

        for ($i = 1; $i <= 5; $i++) {

            $faker = Faker::create();
            MealCategory::create([
                "name" => $categories[$i - 1],
                "description" => $faker->sentence,
            ]);
        }
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_categories');
    }
};
