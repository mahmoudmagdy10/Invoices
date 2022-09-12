<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\TestMarkdown;
use Auth;
use App\Models\User;
use App\Models\Invoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $invoices_count = Invoice::count();
        $invoice_count_1 = Invoice::where('value_status', 1)->count();
        $invoice_count_2 = Invoice::where('value_status', 2)->count();
        $invoice_count_3 = Invoice::where('value_status', 2)->count();

        // return $invoice_count_3;

        if($invoice_count_1 == 0){
            $new_invoice_count_1 = 0;

        }else {
            $new_invoice_count_1 = $invoice_count_1 / $invoices_count *100;
        }

        if($invoice_count_2 == 0){
            $new_invoice_count_2 = 0;

        }else {
            $new_invoice_count_2 = $invoice_count_2 / $invoices_count *100;
        }

        if($invoice_count_3 == 0){
            $new_invoice_count_3 = 0;

        }else {
            $new_invoice_count_3 = $invoice_count_3 / $invoices_count *100;
        }

        $chartjs1 = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 350, 'height' => 200])
        ->labels(['الفواتير المدفوعة', 'الفواتير الغير مدفوعة', 'الفواتير المدفوعة جزئياً'])
        ->datasets([
            [
                "label" => " الفواتير المدفوعة",
                'backgroundColor' => ['#ec5858'],
                'data' => [$new_invoice_count_1]
            ],
            [
                "label" => "الفواتير الغير مدفوعة",
                'backgroundColor' => ['#81b214'],
                'data' => [$new_invoice_count_2]
            ],
            [
                "label" => "الفواتير المدفوعة جزئياً",
                'backgroundColor' => ['#ff9642'],
                'data' => [$new_invoice_count_3]
            ],
        ])
        ->options([]);

        $chartjs2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 340, 'height' => 200])
        ->labels(['الفواتير المدفوعة', 'الفواتير الغير مدفوعة', 'الفواتير المدفوعة جزئياً'])
        ->datasets([
            [
                'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                'data' => [$new_invoice_count_1, $new_invoice_count_2, $new_invoice_count_3]
            ]
        ])
        ->options([]);


        return view('home', compact('chartjs1','chartjs2'));
    }
}
