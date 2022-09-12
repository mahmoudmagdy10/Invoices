<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Section;
use App\Models\Product;

class ReportsController extends Controller
{
    public function index(){
        return view('reports.invoices_report');
    }


    public function search_invoice(Request $request)
    {
        // return $request;

        if($request->radio == 1){
            if($request->type && $request->start_at =='' && $request->end_at==''){

                $type = $request->type;
                $invoices = Invoice::where('status',$type)->get();
                return view('reports.invoices_report',compact('type','invoices'));
                // return $invoice;


            } else {
                $start_date = $request->start_at;
                $end_date = $request->end_at;
                $type = $request->type;
                $invoices = Invoice::where('status',$type)->whereBetween('invoice_date',[$start_date,$end_date])->get();
                return view('reports.invoices_report',compact('type','invoices'));
                // return $invoice;
            }
        } else {
            $invoices = Invoice::where('invoice_number',$request->invoice_number)->get();
            return view('reports.invoices_report')->withDetails('invoices');
            // return $invoice;


        }
    }

    public function users_reports()
    {
        $sections = Section::all();

        return view('reports.users_report',compact('sections'));
    }

    public function search_users_reports(Request $request)
    {
        // return $request;

        if($request->section && $request->product && $request->start_at == '' && $request->end_at == ''){

            $invoices = Invoice::where('section_id',$request->section)->where('product_id',$request->product)->get();
            $section = Section::find($request->section);
            $sections = Section::all();
            $product = Product::find($request->product);

            return view('reports.users_report',compact('invoices','section','product','sections'));
            // return $invoice;

        } else {
            $start_date = $request->start_at;
            $end_date = $request->end_at;
            $invoices = Invoice::where('section_id',$request->section)->where('product_id',$request->product)->whereBetween('invoice_date',[$start_date,$end_date])->get();
            $section = Section::find($request->section);
            $product = Product::find($request->product);
            $sections = Section::all();

            return view('reports.users_report',compact('invoices','section','product','sections','start_date','end_date'));
            // return $product;
        }

    }
}
