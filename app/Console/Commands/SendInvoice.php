<?php

namespace App\Console\Commands;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send invoice to the company owner';

    /**
     * Execute the console command.
     */
    public function handle()
    {

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

        Mail::to(Setting::where('setting', 'invoice_email_destination')->first()->value)->send(new InvoiceMail(url($path)));

    }
}
