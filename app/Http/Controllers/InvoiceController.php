<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Section;
use App\Models\Invoices_details;
use App\Models\Invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InvoiceRequest;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\addInvoice;
use App\Notifications\InvoiceNotification;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Facades\Excel;



class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with(['section','products'])->get();
        $counter =1;
        return view('invoices.invoices',compact('invoices','counter'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();

        return view('invoices.addInvoice',compact('sections'));
        // return $sections;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        // return $request->invoice_Date;
        Invoice::create([
            "invoice_number"    => $request->invoice_number,
            "invoice_date"      => $request->invoice_Date,
            "due_date"          => $request->Due_date,
            "section_id"        => $request->Section,
            "product_id"           => $request->product,
            "discount"          => $request->Discount,
            "rate_vat"          => $request->Rate_VAT,
            "amount_collection" => $request->Amount_collection,
            "amount_commission" => $request->Amount_Commission,
            "value_vat"         => $request->Value_VAT,
            "total"             => $request->Total,
            "note"              => $request->note,
            "value_status"      => 2,
            "status"            => 'غير مدفوعة',
            "user"              => Auth::user()->name,
        ]);

        $invoice_id = Invoice::latest()->first()->id;
        Invoices_details::create([
            'invoice_id'        => $invoice_id,
            'invoice_number'    => $request->invoice_number,
            "product_id"        => $request->product,
            "section_id"        => $request->Section,
            "value_status"      => 2,
            "status"            => 'غير مدفوعة',
            "note"              => $request->note,
            "user"              => Auth::user()->name,
        ]);

        if($request->hasFile('pic')){
            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            Invoices_attachments::create([
                'file_name'         => $file_name,
                'invoice_number'    => $request->invoice_number,
                'created_by'        => Auth::user()->name,
                'invoice_id'        => $invoice_id,
            ]);

            //move File
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/'. $invoice_number),$imageName);

        }

        $user = User::get();
        Notification::send($user, new InvoiceNotification($invoice_id));


        session()->flash('success','تم الأضافه بنجاح');
        return redirect('/invoices');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $sections = Section::all();
        return view('invoices.edit_Invoice',compact('invoice','sections'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request;
        $invoice = Invoice::where('invoice_number','=',$request->original_invoice_number)->first();
        $invoice_id = $invoice->id;

        if( $request->invoice_number == $request->original_invoice_number){
            $invoice->update([
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_Date,
                'due_date' => $request->Due_date,
                'section_id ' => $request->Section,
                'product' => $request->product,
                'amount_collection' => $request->Amount_collection,
                'amount_commission' => $request->Amount_Commission,
                'discount' => $request->Discount,
                'rate_vat' => $request->Rate_VAT,
                'value_vat' => $request->Value_VAT,
                'total' => $request->Total,
                'note' => $request->note,
            ]);

        } else {
            $invoice_details = Invoices_details::where('invoice_number','=',$request->original_invoice_number)->first();
            $invoice_attachments = Invoices_attachments::where('invoice_number','=',$request->original_invoice_number)->get();


            $invoice->update([
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_Date,
                'due_date' => $request->Due_date,
                'section_id ' => $request->Section,
                'product' => $request->product,
                'amount_collection' => $request->Amount_collection,
                'amount_commission' => $request->Amount_Commission,
                'discount' => $request->Discount,
                'rate_vat' => $request->Rate_VAT,
                'value_vat' => $request->Value_VAT,
                'total' => $request->Total,
                'note' => $request->note,
            ]);

            $invoice_details->update([
                'invoice_number' => $request->invoice_number,
                'note' => $request->note,
            ]);

            foreach($invoice_attachments as $attachment){
                $attachment->invoice_number = $request->invoice_number;
                $attachment->save();
            }
            Storage::disk('public_uploads')->move($request->original_invoice_number , $request->invoice_number);
        }
        return redirect('/invoiceDetails/'.$invoice_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // return $request;
        if($request->delete_type == "soft_delete"){

            try{
                $invoice = Invoice::findOrFail($request->invoice_number);
                $invoice->delete();
                session()->flash('success','تم الأرشفة بنجاح');
                return redirect('/invoices');

            } catch (\Exception $e) {
                session()->flash('error','خطأ في الأرشفة ');
                return redirect('/invoices');
            }

        }else {
            try{

                $invoice = Invoice::findOrFail($request->invoice_number);
                $invoice_number = $invoice->invoice_number;
                $invoice_attachments = Invoices_attachments::where('invoice_number','=',$invoice_number)->get();


                Storage::disk('public_uploads')->deleteDirectory($invoice_number);
                $invoice->forceDelete();

                foreach($invoice_attachments as $attachment){
                    $attachment->delete();
                }

                session()->flash('success','تم الحذف بنجاح');
                return redirect('/invoices');

            } catch (\Exception $e) {

                session()->flash('error','خطأ في الحذف ');
                return redirect('/invoices');
            }
        }

    }

    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);
    }

    public function change_payment($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.change_payment',compact('invoice'));
    }


    public function update_payment_status(Request $request)
    {
        $invoice = Invoice::where('invoice_number','=', $request->invoice_number)->first();
        $invoice_details = Invoices_details::where('invoice_number','=', $request->invoice_number)->first();
        // return $request;

        try{
            if($request->payment == 1){
                $invoice->update([
                    'value_status' => $request->payment,
                    'status' => 'مدفوعة',

                ]);

                Invoices_details::create([
                    'invoice_id'        => $invoice->id,
                    'invoice_number'    => $request->invoice_number,
                    "product_id"        => $request->product,
                    "section_id"        => $request->Section,
                    "value_status"      => $request->payment,
                    "status"            => 'مدفوعة',
                    "note"              => $request->note,
                    "user"              => Auth::user()->name,
                    "pay_date"          => $request->pay_date,
                ]);

            }elseif($request->payment == 3){

                $new_allocated = $invoice->allocated + $request->partial_paied;

                if($request->rest_salary == 0){

                    $invoice->update([
                        'value_status'  => 1,
                        'status'        => 'مدفوعة',
                        "allocated"     => $new_allocated,
                        "partial_paied" => $request->partial_paied,
                        "rest_salary"   => $request->rest_salary,


                    ]);

                    Invoices_details::create([
                        'invoice_id'        => $invoice->id,
                        'invoice_number'    => $request->invoice_number,
                        "product_id"        => $request->product,
                        "section_id"        => $request->Section,
                        "value_status"      => 1,
                        "status"            => 'مدفوعة',
                        "note"              => $request->note,
                        "user"              => Auth::user()->name,
                        "pay_date"          => $request->pay_date,
                        "partial_paied"     => $request->partial_paied,
                        "rest_salary"       => $request->rest_salary,
                    ]);
                }else{

                    $invoice->update([
                        'value_status'  => $request->payment,
                        'status'        => 'مدفوع جزئياً',
                        "allocated"     => $new_allocated,
                        "partial_paied" => $request->partial_paied,
                        "rest_salary"   => $request->rest_salary,


                    ]);

                    Invoices_details::create([
                        'invoice_id'        => $invoice->id,
                        'invoice_number'    => $request->invoice_number,
                        "product_id"        => $request->product,
                        "section_id"        => $request->Section,
                        "value_status"      => $request->payment,
                        "status"            => 'مدفوع جزئياً',
                        "note"              => $request->note,
                        "user"              => Auth::user()->name,
                        "pay_date"          => $request->pay_date,
                        "partial_paied"     => $request->partial_paied,
                        "rest_salary"       => $request->rest_salary,
                    ]);
                }
            }

            session()->flash('success','تم التحديث بنجاح');
            return redirect('/invoiceDetails/'.$invoice->id);

        } catch (\Exception $e) {
            session()->flash('error','خطأ في التحديث ');
            return redirect('/invoiceDetails/'.$invoice->id);
        }

    }

    public function paied_invoices()
    {
        $invoices = Invoice::where('value_status','=',1)->with(['section','products'])->get();
        $counter =1;
        return view('invoices.paied_invoices',compact('invoices','counter'));
    }

    public function partial_paied_invoices()
    {
        $invoices = Invoice::where('value_status','=',3)->with(['section','products'])->get();
        $counter =1;
        return view('invoices.partial_paied_invoices',compact('invoices','counter'));
    }

    public function unpaied_invoices()
    {
        $invoices = Invoice::where('value_status','=',2)->with(['section','products'])->get();
        $counter =1;
        return view('invoices.unpaied_invoices',compact('invoices','counter'));
    }

    public function print_invoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoices.print_invoice',compact('invoice'));
        // return $request;
    }

    public function export()
    {
        return Excel::download(new InvoiceExport, 'invoices.xlsx');
    }

    public function read_all()
    {
        $unReadedNotifications = auth()->user()->unreadNotifications;

        if($unReadedNotifications){
            $unReadedNotifications->markAsRead();
            return back();
        }
    }

}
