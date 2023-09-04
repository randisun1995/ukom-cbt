<?php

namespace App\Http\Controllers\Participant;

use App\Models\Grade;
use App\Models\ExamGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {


        //get exam groups
        $exam_groups = ExamGroup::with('exam_session', 'participant.position', 'participant.position.level')
            ->where('participant_id', auth()->guard('participant')->user()->id)
            ->get();

        //define variable array
        $data = [];

        //get nilai
        foreach($exam_groups as $exam_group) {

            //get data nilai / grade
            $grade = Grade::where('exam_id', $exam_group->exam_id)
								->where('exam_session_id', $exam_group->exam_session_id)
                ->where('participant_id', auth()->guard('participant')->user()->id)
                ->first();

            //jika nilai / grade kosong, maka buat baru
            if($grade == null) {

                //create defaul grade
                $grade = new Grade();
                $grade->exam_id         = $exam_group->exam_id;
                $grade->exam_session_id = $exam_group->exam_session_id;
                $grade->participant_id  = auth()->guard('participant')->user()->id;
                $grade->duration        = $exam_group->exam->duration * 60000;
                $grade->total_correct   = 0;
                $grade->grade           = 0;
                $grade->save();

            }

            if($grade->counter > 0) {

                // $diferen = (($grade->duration) - ($grade->counter));
                // $grade->end_point = Carbon::now()->addMilliseconds($diferen);
                // $grade->start_point = Carbon::now();
                $dif = $grade->counter - $grade->summary;
                $grade->duration = $grade->duration - $dif;
                $grade->summary = $grade->counter;
                $grade->update();
                }


            $data[] = [
                'exam_group' => $exam_group,
                'grade'      => $grade
            ];

        }


        //return with inertia
        return inertia('Participant/Dashboard/Index', [
            'exam_groups' => $data,
        ]);
    }
}
