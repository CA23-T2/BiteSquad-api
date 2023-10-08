<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Meal;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = OrderResource::collection($request->user()->orders);

        if(sizeof($orders) === 0) {
            return new JsonResponse([
                "success" => false,
                "message" => "You don't have any orders yet."
            ]);
        }

        return new JsonResponse([
            "success" => true,
            "data" => $orders,
            "message" => "Orders fetched successfully."
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Uncomment to enable time restriction for orders
//        if(intval(date('H')) >= 9) {
//
//            return new JsonResponse([
//                "success" => false,
//                "data" => [],
//                "message" => "Sorry, orders are closed for today, please order before 9 AM."
//            ]);
//        }

        $user = $request->user();

        $order = new Order([
            'order_date' => now(),
            'status' => 'Pending',
        ]);

        $user->orders()->save($order);

        foreach ($request->meals as $index => $mealId) {
            $meal = Meal::find($mealId);

            if ($meal) {
                $order->meals()->attach($meal, ['quantity' => $request->quantities[$index]]);
            }
        }

        return response()->json([
            "Order created succesfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $orders = $request->user()->orders;

        $foundOrder = $orders->where('id', $id)->first();

        if (!empty($foundOrder)) {

            return new JsonResponse([
                "success" => true,
                "data" => new OrderResource($foundOrder),
                "message" => "Order fetched successfully."
            ]);

        } else {

            return new JsonResponse([
                "success" => false,
                "data" => [],
                "message" => "Order not found, it either does not exist or does not belong to you."
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Uncomment to enable time restriction for orders
//        if(intval(date('H')) >= 9) {
//
//            return new JsonResponse([
//                "success" => false,
//                "data" => [],
//                "message" => "Sorry, orders are closed for today, please order before 9 AM."
//            ]);
//        }

        $orders = $request->user()->orders;

        $foundOrder = $orders->where('id', $id)->first();

        if (!empty($foundOrder)) {

            $foundOrder->meals()->detach();

            foreach ($request->meals as $index => $mealId) {
                $meal = Meal::find($mealId);

                if ($meal) {
                    $foundOrder->meals()->attach($meal, ['quantity' => $request->quantities[$index]]);
                }
            }

            return new JsonResponse([
                "success" => true,
                "data" => [],
                "message" => "Order edited successfully."
            ]);

        } else {

            return new JsonResponse([
                "success" => false,
                "data" => [],
                "message" => "Order not found, it either does not exist or does not belong to you."
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $orders = $request->user()->orders;

        $foundOrder = $orders->where('id', $id)->first();



        if (!empty($foundOrder)) {

            $foundOrder->delete();

            return new JsonResponse([
                "success" => true,
                "data" => [],
                "message" => "Order deleted successfully."
            ]);

        } else {

            return new JsonResponse([
                "success" => false,
                "data" => [],
                "message" => "Order not found, it either does not exist or does not belong to you."
            ], 404);
        }
    }
}
