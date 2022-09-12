<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Requests\SectionRequest;
use Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        $counter =1;
        return view('sections.sections')->with(compact('sections','counter'));
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
    public function store(SectionRequest $request)
    {

        Section::create([
            'section_name'=> $request->section_name,
            'description'=>  $request->description,
            'Created_by' =>  Auth::user()->name,
        ]);
        session()->flash('success','تم الأضافه بنجاح');
        return redirect('/sections');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request)
    {
        try{
            $section = Section::find($request->id);
            $section->update([
                'section_name' => $request->section_name,
                'description' => $request->description,
            ]);


            session()->flash('success','تم التعديل بنجاح');
            return redirect('/sections');

        } catch (\Exception $e) {
            session()->flash('error','خطأ في التعديل ');
            return redirect('/sections');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $section = Section::find($request->id);
            $section->delete();


            session()->flash('success','تم الحذف بنجاح');
            return redirect('/sections');

        } catch (\Exception $e) {
            session()->flash('error','خطأ في الحذف ');
            return redirect('/sections');
        }
    }
}
