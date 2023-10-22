<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   

    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        $orders =  Order::all();

        $statuses = Status::all();

        $data['orders'] = $orders;
        $data['statuses'] = $statuses;

        return view('admin.orders.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function today()
    {

        $orders = Order::whereDay('delivery_date', now()->day)->get();
        $statuses = Status::all();

        $data['orders'] = $orders;
        $data['statuses'] = $statuses;

        return view('admin.orders.today', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        $statuses = Status::all();
        $data['order'] = $order;
        $data['statuses'] = $statuses;

        return view('admin.orders.show', $data);
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

        $order->update(['status_id' => $request->status_id]);
        // return $request->fromWhere;
        // return redirect()->route('orders-index');
        
        switch ($request->fromWhere) {  
            case 'show':
                return redirect()->route('orders-index');
                break;
            case 'index':
                return redirect()->route('orders-index');
                break;
            case 'today':
                return redirect()->route('orders-today');
                break;
            
            default:
            return redirect()->route('orders-index');
                break;
        }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
