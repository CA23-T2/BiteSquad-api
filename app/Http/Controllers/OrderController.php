<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders =  Order::whereDay('delivery_date', now()->day)->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function all()
    {
        $orders =  Order::all();

        return view('admin.orders.all', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function done()
    {

        $all_orders = Order::whereDay('delivery_date', now()->day)->get();
        $orders = $all_orders->filter(function ($order) {
            return $order->status->name === "Gotovo";
        });

        return view('admin.orders.done', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $order->update(['status_id' => 2]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
