<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{

    public function show () {

        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $orders = Order::where('status_id', 2)
        ->whereDate('created_at', '>=', $currentMonthStart)
            ->whereDate('created_at', '<=', $currentMonthEnd)
            ->with('meals')
            ->get();

        $totalPricesByDay = [];

        foreach ($orders as $order) {
            $deliveryDate = Carbon::parse($order->delivery_date)->toDateString();

            if (!isset($totalPricesByDay[$deliveryDate])) {
                $totalPricesByDay[$deliveryDate] = 0;
            }

            foreach ($order->meals as $meal) {
                $mealQuantity = $meal->pivot->quantity;
                $totalPricesByDay[$deliveryDate] += $mealQuantity * $meal->price;
            }
        }

        $result = [];
        $pricesPerDay = [];

        foreach ($totalPricesByDay as $date => $totalPrice) {
            $pricesPerDay[] = [
                'label' => "Ketering za $date",
                'total_price' => $totalPrice,
            ];
        }

        $total = array_sum(array_column($pricesPerDay, 'total_price'));

        $result['prices_per_day'] = $pricesPerDay;
        $result['total'] = $total;


        $pdf = Pdf::loadView('admin.pdf.invoice', $result);

        $path = 'pdfs/'.Str::uuid().'.pdf' ;

        $pdf->save(public_path($path));

        return redirect(asset($path));

//        return view('admin.pdf.invoice', $result);
    }
}
