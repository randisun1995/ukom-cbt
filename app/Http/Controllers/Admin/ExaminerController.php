<?php

namespace App\Http\Controllers\Admin;

use App\Models\Examiner;
use App\Models\ExamGroup;
use App\Models\ExamSession;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Models\ExaminerGroup;
use App\Http\Controllers\Controller;

class ExaminerController extends Controller
{
    public function index()
    {
        //get examiner
        $examiners = Examiner::when(request()->q, function($examiners) {
            $examiners = $examiners->where('name', 'like', '%'. request()->q . '%');
        })->latest()->paginate(10);


        //append query string to pagination links
        $examiners->appends(['q' => request()->q]);


        return inertia('Admin/Examiners/Index', [
            'examiners' => $examiners
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $examsessions = ExamSession::with('exam.position','exam.position.level')->when('exam.position.level')->get();

        //render with inertia
        return inertia('Admin/Examiners/Create', [
            'examsessions' => $examsessions,
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
            'nip'               => 'required|unique:examiners',
            'name'              => 'required|string|max:255',
            'role'              => 'required',
            'examsession_id'    => 'required',
            'password'          => 'required|confirmed',

        ]);

        //create examiner
        Examiner::create([
            'nip'               => $request->nip,
            'name'              => $request->name,
            'role'              => $request->role,
            'examsession_id'    => $request->examsession_id,
            'password'          => $request->password
        ]);

        //redirect
        return redirect()->route('admin.examiners.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //get examiner
       $examiner = Examiner::findOrFail($id);

       //get relation exam_groups with pagination
       $examiner->setRelation('examiner_groups', $examiner->examiner_groups()->with('participant.position')->paginate(5));

       //render with inertia
       return inertia('Admin/Examiners/Show', [
           'examiner'  => $examiner,

       ]);
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
         $examiner = Examiner::findOrFail($id);

         //get exam
        $examsessions = ExamSession::with('exam.position','exam.position.level')->when('exam.position.level')->get();

         //render with inertia
         return inertia('Admin/Examiners/Edit', [
             'examiner' => $examiner,
             'examsessions' => $examsessions,

         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Examiner $examiner)
    {
        $request->validate([

            'name'              => 'required|string|max:255',
            'nip'               => 'required|unique:participants,nip,'.$examiner->id,
            'role'              => 'required',
            'examsession_id'    => 'required',
            'password'          => 'confirmed'
        ]);

        //check password
        if($request->password == "") {

            //update student without password
            $examiner->update([

                'name'         => $request->name,
                'nip'          => $request->nip,
                'role'         => $request->role,
                'examsession_id' => $request->examsession_id
            ]);

        } else {

            //update aprraiser with password
            $examiner->update([
                'name'          => $request->name,
                'nip'           => $request->nip,
                'role'          => $request->role,
                'examsession_id' => $request->examsession_id,
                'password'      => $request->password,

            ]);

        }

        //redirect
        return redirect()->route('admin.examiners.index');
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
         $examiner = Examiner::findOrFail($id);

         //delete student
         $examiner->delete();

         //redirect
         return redirect()->route('admin.examiners.index');
    }

    public function createEnrolle(Examiner $examiner)
    {
         //get exams
         $examsession_id = $examiner->examsession_id;

        //get participants already enrolled
        $participants_enrolled = ExaminerGroup::where('examsession_id', $examiner->examsession_id)->pluck('participant_id')->all();

        $participants = ExamGroup::with('participant.position.level')->where('exam_session_id', $examsession_id)->whereNotIn('participant_id', $participants_enrolled)
        ->get();

        //render with inertia
        return inertia('Admin/ExaminerGroups/Create', [
            'examiner'  => $examiner,
            'participants'  => $participants,
            'examsession_id'  => $examsession_id,
        ]);
    }

     /**
     * storeEnrolle
     *
     * @param  mixed $exam_session
     * @return void
     */
    public function storeEnrolle(Request $request, Examiner $examiner)
    {

        //validate request
        $request->validate([
            'participant_id'    => 'required',
            'examsession_id'    => 'required',
        ]);

        //create exam_group
        foreach($request->participant_id as $participant_id) {

            //select participant
            $participant = Participant::findOrFail($participant_id);

            //create exam_group
            ExaminerGroup::create([
                'examiner_id'      => $examiner->id,
                'participant_id'    => $participant->id,
                'examsession_id'    => $examiner->examsession_id,
            ]);
        }

        //redirect
        return redirect()->route('admin.examiners.show', $examiner->id);
    }

    public function destroyEnrolle(Examiner $examiner, ExaminerGroup $examiner_group)
    {
        //delete exam_group
        $examiner_group->delete();

        //redirect
        return redirect()->route('admin.examiners.show', $examiner->id);
    }
}

