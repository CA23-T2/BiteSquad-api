<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{

    public function index() {
        $invoices = Invoice::all();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function newInvoice () {

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

        $path = 'pdfs/'.Str::uuid().'.pdf';
        $invoice = new Invoice();
        $invoice->pdf_link = $path;
        $invoice->save();

        $total = array_sum(array_column($pricesPerDay, 'total_price'));

        $result['prices_per_day'] = $pricesPerDay;
        $result['total'] = $total;
        $result['invoiceNumber'] = date("Y").'/'.$invoice->id;

        $pdf = Pdf::loadView('admin.pdf.invoice', $result);

        $pdf->save(public_path($path));

        Mail::to(Setting::where('setting', 'invoice_email_destination')->first()->value)->send(new InvoiceMail($path));

        return redirect(asset($path));

    }
}
