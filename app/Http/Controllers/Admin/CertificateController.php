<?php

namespace App\Http\Controllers\Admin;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //get sertifikat
       $certificates = Certificate::when(request()->q, function($certificates) {
        $certificates = $certificates->where('nip', 'like', '%'. request()->q . '%');
    })->latest()->paginate(5);

    //append query string to pagination links
    $certificates->appends(['q' => request()->q]);

    //render with inertia
    return inertia('Admin/Certificates/Index', [
        'certificates' => $certificates,
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
           return inertia('Admin/Certificates/Create',[

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

        //validate request
        $request->validate([
            'nip' => 'required',
            'title' => 'required',
            'link' => 'required'
        ]);

        //create level
        Certificate::create([
            'nip' => $request->nip,
            'title' => $request->title,
            'link' => $request->link,
        ]);

        //redirect
        return redirect()->route('admin.certificates.index');
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
         //get certificate
         $certificate = Certificate::findOrFail($id);



         //render with inertia
         return inertia('Admin/Certificates/Edit', [
             'certificate' => $certificate,

         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificate $certificate)
    {
       //validate request
       $request->validate([
        'nip' => 'required',
        'title' => 'required',
        'link' => 'required'
    ]);

    //update classroom
    $certificate->update([
        'nip' => $request->nip,
        'title' => $request->title,
        'link' => $request->link,
    ]);

    //redirect
    return redirect()->route('admin.certificates.index');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
           //get classroom
           $certificate = Certificate::findOrFail($id);

           //delete classroom
           $certificate->delete();

           //redirect
           return redirect()->route('admin.certificates.index');
    }
}
