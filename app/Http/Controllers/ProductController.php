<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Http\Requests\ProductRequest;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        $products = Product::with(['section'])->get();
        $counter =1;

        return view('products.products',compact('products','sections','counter'));
        // return $products;

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
    public function store(ProductRequest $request)
    {
        try{
            Product::create([
                'product_name'=> $request->product_name,
                'description'=>  $request->description,
                'section_id' =>  $request->section_id ,
            ]);
            session()->flash('success','تم الأضافة بنجاح');
            return redirect('/products');

        } catch (\Exception $e) {
            session()->flash('error','خطأ في الإضافة ');
            return redirect('/products');
            // return $request;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request)
    {
            // return $product;
        try{
            $section_id = Section::where('section_name',$request->section_name)->first()->id;
            $product = Product::find($request->id);

            $product->update([
                'product_name'=> $request->product_name,
                'description'=>  $request->description,
                'section_id' =>  $section_id,
            ]);
            session()->flash('success','تم التعديل بنجاح');
            return redirect('/products');

        } catch (\Exception $e) {
            session()->flash('error','خطأ في التعديل ');
            return redirect('/products');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $product = Product::find($request->id);
            $product->delete();


            session()->flash('success','تم الحذف بنجاح');
            return redirect('/products');

        } catch (\Exception $e) {
            session()->flash('error','خطأ في الحذف ');
            return redirect('/products');
        }
    }
}
