<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Invoices_attachments;
use Illuminate\Support\Facades\Storage;



class InvoicesArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        $counter =1;
        return view('invoices.archive',compact('invoices','counter'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $archived_invoice = Invoice::withTrashed()->where('id','=',$request->invoice_number)->restore();
        $invoices = Invoice::onlyTrashed()->get();
        $counter =1;
        session()->flash('success','تم إعادة الفاتورة بنجاح');
        return view('invoices.archive',compact('invoices','counter'));
        // return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{

            $invoice = Invoice::withTrashed()->where('invoice_number','=',$request->invoice_number)->first();
            $invoice_attachments = Invoices_attachments::where('invoice_number','=',$request->invoice_number)->get();

            Storage::disk('public_uploads')->deleteDirectory($request->invoice_number);
            $invoice->forceDelete();

            foreach($invoice_attachments as $attachment){
                $attachment->delete();
            }

            session()->flash('success','تم الحذف بنجاح');
            return redirect('/InvoicesArchive');
            // return $invoice;

        } catch (\Exception $e) {

            session()->flash('error','خطأ في الحذف ');
            return redirect('/InvoicesArchive');
        }

    }

}
