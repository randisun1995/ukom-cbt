<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SBEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $sbe = ExaminerGroup::where('examiner_id', auth()->guard('examiner')->user()->id)
        // ->when(request()->q, function ($examinergroups) {
        //     $examinergroups = $examinergroups->where('name', 'like', '%' . request()->q . '%');
        // })
        // ->with('participant.position.level')
        // ->latest()
        // ->paginate(10);

        // // Iterate through each examiner group and add the evaluation status
        // $examinergroups->each(function ($examinergroup) {
        // // Check if there is an Evaluation record for the examiner group and participant
        // $evaluation = Evaluation::where('examiner_group_id', $examinergroup->id)
        //     ->where('participant_id', $examinergroup->participant->id)
        //     ->first(); // Use first() to get a single record or null if not found

        // // Determine the status (1 if evaluation exists, 0 if not)
        // $evaluationStatus = !is_null($evaluation) ? 1 : 0;

        // // Add the evaluation status to the examiner group object
        // $examinergroup->status = $evaluationStatus;
        // });

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
