<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\ExamGroup;

class ExamSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get exam_sessions
        $exam_sessions = ExamSession::when(request()->q, function($exam_sessions) {
            $exam_sessions = $exam_sessions->where('title', 'like', '%'. request()->q . '%');
        })->with('exam.position','exam.position.level','exam_groups')->latest()->paginate(5);

        //append query string to pagination links
        $exam_sessions->appends(['q' => request()->q]);

        //render with inertia
        return inertia('Admin/ExamSessions/Index', [
            'exam_sessions' => $exam_sessions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get exams
        $exams = Exam::all();

        //render with inertia
        return inertia('Admin/ExamSessions/Create', [
            'exams' => $exams,
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
            'title'         => 'required',
            'exam_id'       => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
        ]);

        //create exam_session
        ExamSession::create([
            'title'         => $request->title,
            'exam_id'       => $request->exam_id,
            'start_time'    => date('Y-m-d H:i:s', strtotime($request->start_time)),
            'end_time'      => date('Y-m-d H:i:s', strtotime($request->end_time)),
        ]);

        //redirect
        return redirect()->route('admin.exam_sessions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $exam_session
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get exam_session
        $exam_session = ExamSession::with('exam.position', 'exam.position.level')->findOrFail($id);

        //get relation exam_groups with pagination
        $exam_session->setRelation('exam_groups', $exam_session->exam_groups()->with('participant.position')->paginate(5));

        //render with inertia
        return inertia('Admin/ExamSessions/Show', [
            'exam_session'  => $exam_session,
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
        //get exam_session
        $exam_session = ExamSession::findOrFail($id);

        //get exams
        $exams = Exam::all();

        //render with inertia
        return inertia('Admin/ExamSessions/Edit', [
            'exam_session'  => $exam_session,
            'exams'         => $exams,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamSession $exam_session)
    {
        //validate request
        $request->validate([
            'title'         => 'required',
            'exam_id'       => 'required',
            'start_time'    => 'required',
            'end_time'      => 'required',
        ]);

        //update exam_session
        $exam_session->update([
            'title'         => $request->title,
            'exam_id'       => $request->exam_id,
            'start_time'    => date('Y-m-d H:i:s', strtotime($request->start_time)),
            'end_time'      => date('Y-m-d H:i:s', strtotime($request->end_time)),
        ]);

        //redirect
        return redirect()->route('admin.exam_sessions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get exam_session
        $exam_session = ExamSession::findOrFail($id);

        //delete exam_session
        $exam_session->delete();

        //redirect
        return redirect()->route('admin.exam_sessions.index');
    }

    /**
     * createEnrolle
     *
     * @param  mixed $exam_session
     * @return void
     */
    public function createEnrolle(ExamSession $exam_session)
    {
        //get exams
        $exam = $exam_session->exam;

        if ($exam->position->title === "Umum") {
            $participantsEnrolled = ExamGroup::where('exam_id',  $exam_session->id)
                ->where('exam_session_id',  $exam_session->id)
                ->pluck('participant_id')
                ->all();

                $participants = Participant::with('position')
                ->whereNotIn('id', $participantsEnrolled)
                ->get();
        } else {

                //get participants already enrolled
                $participants_enrolled = ExamGroup::where('exam_id', $exam->id)->where('exam_session_id', $exam_session->id)->pluck('participant_id')->all();

                //get participants
                $participants = Participant::with('position')->where('position_id', $exam->position_id)->whereNotIn('id', $participants_enrolled)->get();
        }

        //render with inertia
        return inertia('Admin/ExamGroups/Create', [
            'exam'          => $exam,
            'exam_session'  => $exam_session,
            'participants'  => $participants,
        ]);
    }

    /**
     * storeEnrolle
     *
     * @param  mixed $exam_session
     * @return void
     */
    public function storeEnrolle(Request $request, ExamSession $exam_session)
    {
        //validate request
        $request->validate([
            'participant_id'    => 'required',
        ]);

        //create exam_group
        foreach($request->participant_id as $participant_id) {

            //select participant
            $participant = Participant::findOrFail($participant_id);

            //create exam_group
            ExamGroup::create([
                'exam_id'         => $request->exam_id,
                'exam_session_id' => $exam_session->id,
                'participant_id'  => $participant->id,
            ]);
        }

        //redirect
        return redirect()->route('admin.exam_sessions.show', $exam_session->id);
    }

    public function destroyEnrolle(ExamSession $exam_session, ExamGroup $exam_group)
    {
        //delete exam_group
        $exam_group->delete();

        //redirect
        return redirect()->route('admin.exam_sessions.show', $exam_session->id);
    }

}
