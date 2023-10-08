<?php

namespace Tests\Feature;

use App\Models\Meal;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Date;
use Tests\TestCase;

class TableTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $userId = 1;

        $mealIds = [1, 2, 3];
        $quantities = [2, 1, 3];

        $user = User::find(2);

        $order = new Order([
            'order_date' => now(),
            'status' => 'Pending',
        ]);

        $user->orders()->save($order);

        foreach ($mealIds as $index => $mealId) {
            $meal = Meal::find($mealId);

            if ($meal) {
                $order->meals()->attach($meal, ['quantity' => $quantities[$index]]);
            }
        }
    }
}
