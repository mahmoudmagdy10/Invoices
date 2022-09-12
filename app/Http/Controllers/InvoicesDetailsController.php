<?php

namespace App\Http\Controllers;

use App\Models\Invoices_details;
use Illuminate\Http\Request;
use Auth;
use App\Models\Invoice;
use App\Models\Section;
use App\Models\Invoices_attachments;
use Illuminate\Support\Facades\Storage;


class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  \App\Models\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $invoices = Invoice::where('id','=',$id)->with(['section','products','Invoice_details','Invoice_attachments'])->get();
            $counter =1;

            return view('invoices.invoicesDetails',compact('invoices','counter'));
            // return $invoices->invoice_number;
            // foreach($invoices as $r){
            //     return $r->Invoice_details->invoice_number;
            // }
        } catch (\Exception $e) {
            session()->flash('error','العنصر غير موجود ');
            return redirect('/invoices');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $invoice = Invoices_attachments::findOrFail($request->id);
            $invoice->delete();
            session()->flash('success','تم الحذف بنجاح');
            return back();
        } catch (\Exception $e) {
            session()->flash('error','خطأ في الحذف ');
            return redirect('/invoiceDetails/{{$request->id}}');
        }
    }

    public function open_file($invoice_number , $file_name)
    {
        $file = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'. $file_name);
        return response()->file($file);
    }
    public function download_file($invoice_number , $file_name)
    {
        return Storage::disk('public_uploads')->download($invoice_number.'/'. $file_name);

    }
    public function addAttachment(Request $request)
    {
        $validated = $request->validate([
            'pic' => 'required|mimes:pdf,jpg,png,jpeg',
        ]);
        // return $request->invoice_number;
        if($request->hasFile('attachment')){
            $invoice = Invoice::where('invoice_number','=', $request->invoice_number)->first();
            $image = $request->file('attachment');
            $file_name = $image->getClientOriginalName();

            Invoices_attachments::create([
                'file_name'         => $file_name,
                'invoice_number'    => $request->invoice_number,
                'created_by'        => Auth::user()->name,
                'invoice_id'        => $invoice->id,
            ]);

            //move File
            $imageName = $request->attachment->getClientOriginalName();
            $request->attachment->move(public_path('Attachments/'. $request->invoice_number),$imageName);

            session()->flash('success','تم الأضافه بنجاح');
            return redirect('/invoiceDetails/'.$invoice->id);

        }else {
            session()->flash('success','تم الأضافه بنجاح');
            return redirect('/invoiceDetails/'.$invoice->id);

        }
    }
}
