<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Models\ExaminerGroup;
use App\Models\Indicator;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Get examiner groups
            $examinergroups = ExaminerGroup::where('examiner_id', auth()->guard('examiner')->user()->id)
            ->when(request()->q, function ($examinergroups) {
                $examinergroups = $examinergroups->where('name', 'like', '%' . request()->q . '%');
            })
            ->with('participant.position.level')
            ->latest()
            ->paginate(10);

            // Iterate through each examiner group and add the evaluation status
            $examinergroups->each(function ($examinergroup) {
            // Check if there is an Evaluation record for the examiner group and participant
            $evaluation = Evaluation::where('examiner_group_id', $examinergroup->id)
                ->where('participant_id', $examinergroup->participant->id)
                ->first(); // Use first() to get a single record or null if not found

            // Determine the status (1 if evaluation exists, 0 if not)
            $evaluationStatus = !is_null($evaluation) ? 1 : 0;

            // Add the evaluation status to the examiner group object
            $examinergroup->status = $evaluationStatus;
            });

// $examinergroups now contains the evaluation status for each examiner group as a property named "status"

        return inertia('Examiners/Interview/Index', [
            'examinergroups' => $examinergroups,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $participant = ExaminerGroup::with('participant.position.level')->findOrFail($id);
        $indicators = Indicator::when(request()->q, function($indicators) {
            $indicators = $indicators->where('name', 'like', '%'. request()->q . '%');
        })->latest()->paginate(10);

         // return $appraisergroups;
         return inertia('Examiners/Interview/Create', [
            'participant' =>  $participant,
            'indicators' => $indicators,
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
        // return $request;
       // Ambil data scores dari request

       $scores = $request->input('scores');

       // Loop melalui scores dan simpan ke dalam database
       foreach ($scores as $scoreData) {
           Evaluation::create([
               'examiner_group_id' => $scoreData['examiner_group_id'],
               'participant_id' => $scoreData['participant_id'],
               'indicator_id' => $scoreData['indicator_id'],
               'score' => $scoreData['score'],
           ]);
       }

        return redirect()->route('examiner.interviews.index');
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
        $participant = ExaminerGroup::with('participant.position.level')->findOrFail($id);
        $indicators = Indicator::when(request()->q, function($indicators) {
            $indicators = $indicators->where('name', 'like', '%'. request()->q . '%');
        })->latest()->paginate(10);
        $grade = Evaluation::where('examiner_group_id', $participant->id)
        ->where('participant_id', $participant->participant_id)
        ->get();
        $gradeMap = [];
                foreach($grade as $gr) {
                $gradeMap[$gr->indicator_id] = $gr->score;
                }

        return inertia('Examiners/Interview/Edit', [

        'participant' =>  $participant,
        'indicators' => $indicators,
        'grade' => $grade,
        'gradeMap' => $gradeMap,
        ]);
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
         // Validasi data yang diterima dari request jika diperlukan

         $data = $request->input('scores'); // Mendapatkan data nilai dari request

         // Loop melalui data nilai dan update ke dalam database
         foreach ($data as $score) {
             Evaluation::where([
                 'examiner_group_id' => $score['examiner_group_id'],
                 'participant_id' => $score['participant_id'],
                 'indicator_id' => $score['indicator_id'],
             ])->update([
                 'score' => $score['score'],
             ]);
         }


         return redirect()->route('examiner.interviews.index');
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
