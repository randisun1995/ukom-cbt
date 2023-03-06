<?php

namespace App\Http\Controllers\Admin;

use App\Models\Participant;
use App\Models\Position;
use App\Models\Level;
use App\Models\Instansi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ParticipantsImport;
use Maatwebsite\Excel\Facades\Excel;

class ParticipantController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get students
        $participants = Participant::when(request()->q, function($participants) {
            $participants = $participants->where('name', 'like', '%'. request()->q . '%');
        })->with('position')->latest()->paginate(10);

        //append query string to pagination links
        $participants->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/Participants/Index', [
            'participants' => $participants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get data
        $levels = Level::all();
        $positions = Position::all();
        $instansis = Instansi::all();

        //render with inertia
        return inertia('Admin/Participants/Create', [
            'levels' => $levels,
            'positions' => $positions,
            'instansis' => $instansis,
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
            'position_id'   => 'required',
            'level_id'      => 'required',
            'name'          => 'required|string|max:255',
            'nip'           => 'required|unique:participants',
            'type'          => 'required',
            'password'      => 'required|confirmed',
            'instansi_id'  => 'required'
        ]);



        //create student
        Participant::create([
            'position_id'   => $request->position_id,
            'level_id'      => $request->level_id,
            'name'          => $request->name,
            'nip'          => $request->nip,
            'type'          => $request->type,
            'password'      => $request->password,
            'instansi_id'  => $request->instansi_id
        ]);

        //redirect
        return redirect()->route('admin.participants.index');
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
        $participant = Participant::findOrFail($id);

        //get classrooms
        $positions = Position::all();
        $levels = Level::all();
        $instansis = Instansi::all();
        //render with inertia
        return inertia('Admin/Participants/Edit', [
            'participant' => $participant,
            'positions' => $positions,
            'instansis' => $instansis,
            'levels' => $levels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Participant $participant)
    {
        //validate request
        $request->validate([
            'position_id'   => 'required',
            'level_id'      => 'required',
            'name'          => 'required|string|max:255',
            'nip'           => 'required|unique:participants,nip,'.$participant->id,
            'type'          => 'required',
            'instansi_id'  => 'required',
            'password'      => 'confirmed'
        ]);

        //check passwordy
        if($request->password == "") {

            //update student without password
            $participant->update([
                'position_id'   => $request->position_id,
                'level_id'      => $request->level_id,
                'name'          => $request->name,
                'nip'          => $request->nip,
                'type'          => $request->type,
                'instansi_id'  => $request->instansi_id
            ]);

        } else {

            //update student with password
            $participant->update([
                'position_id'   => $request->position_id,
                'level_id'      => $request->level_id,
                'name'          => $request->name,
                'nip'          => $request->nip,
                'type'          => $request->type,
                'password'      => $request->password,
                'instansi_id'  => $request->instansi_id
            ]);

        }

        //redirect
        return redirect()->route('admin.participants.index');

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
        $participant = Participant::findOrFail($id);

        //delete student
        $participant->delete();

        //redirect
        return redirect()->route('admin.participants.index');
    }

    /**
     * import
     *
     * @return void
     */
    public function import()
    {
        return inertia('Admin/Participants/Import');
    }

    /**
     * storeImport
     *
     * @param  mixed $request
     * @return void
     */
    public function storeImport(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // import data
        Excel::import(new ParticipantsImport(), $request->file('file'));

        //redirect
        return redirect()->route('admin.participants.index');
    }
}
