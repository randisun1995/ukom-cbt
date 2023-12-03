<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndicatorCathegory;
use Illuminate\Http\Request;

class IndicatorCathegoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //get indicator
         $indicatorcathegories = IndicatorCathegory::when(request()->q, function($indicatorcathegories) {
            $indicatorcathegories = $indicatorcathegories->where('name', 'like', '%'. request()->q . '%');
        })->latest()->paginate(10);


        //append query string to pagination links
        $indicatorcathegories->appends(['q' => request()->q]);

        return inertia('Admin/IndicatorCathegory/Index', [
            'indicatorcathegories' => $indicatorcathegories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //render with inertia
        return inertia('Admin/IndicatorCathegory/Create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //create appraiser
         IndicatorCathegory::create([
            'title'               => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.indicators.cathegory.index');
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
        //get participant
        $indicatorcathegory = IndicatorCathegory::findOrFail($id);

        //render with inertia
        return inertia('Admin/Indicators/Edit', [
            'indicatorcathegory' => $indicatorcathegory,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IndicatorCathegory $indicatorcathegory)
    {
        //validate request
        $request->validate([
            'title'              => 'required',
        ]);

        //create appraiser
        $indicatorcathegory->update([
            'title'               => $request->title,
        ]);

        //redirect
        return redirect()->route('admin.indicators.cathegory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          //get
          $indicatorcathegory = IndicatorCathegory::findOrFail($id);

          //delete
          $indicatorcathegory->delete();

          //redirect
          return redirect()->route('admin.indicators.cathegory.index');
    }
}
