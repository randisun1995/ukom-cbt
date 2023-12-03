<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Indicator;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Indirect;

class IndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //get indicator
         $indicators = Indicator::when(request()->q, function($indicators) {
            $indicators = $indicators->where('name', 'like', '%'. request()->q . '%');
        })->latest()->paginate(10);


        //append query string to pagination links
        $indicators->appends(['q' => request()->q]);

        return inertia('Admin/Indicators/Index', [
            'indicators' => $indicators
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
        return inertia('Admin/Indicators/Create', [

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
        Indicator::create([
            'title'               => $request->title,
            'cathegory'           => $request->cathegory,
            'sub'                 => $request->sub,
            'subsub'              => $request->subsub,
            'status'              => $request->status
        ]);

        //redirect
        return redirect()->route('admin.indicators.index');
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
          $indicators = Indicator::findOrFail($id);

          //render with inertia
          return inertia('Admin/Indicators/Edit', [
              'indicators' => $indicators,

          ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Indicator $indicator)
    {
       //validate request
       $request->validate([
        'title'              => 'required',
        'cathegory'          => 'required',
        'sub'                => 'required',
        'subsub'             => 'required',
        'status'             => 'required',

    ]);

    //create appraiser
    $indicator->update([
        'title'               => $request->title,
        'cathegory'           => $request->cathegory,
        'sub'                 => $request->sub,
        'subsub'              => $request->subsub,
        'status'              => $request->status
    ]);

    //redirect
    return redirect()->route('admin.indicators.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get student
        $indicator = Indicator::findOrFail($id);

        //delete student
        $indicator->delete();

        //redirect
        return redirect()->route('admin.indicators.index');
    }
}
