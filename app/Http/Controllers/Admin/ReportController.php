<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Grade;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Exports\GradesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //geta ll exams
        $exams = Exam::with('position', 'position.level')->get();

        return inertia('Admin/Reports/Index', [
            'exams'         => $exams,
            'grades'        => []
        ]);
    }

    /**
     * filter
     *
     * @param  mixed $request
     * @return void
     */
    public function filter(Request $request)
    {
        $this->validate($request, [
            'exam_id'       => 'required',
        ]);

        //geta ll exams
        $exams = Exam::with('position', 'position.level')->get();

        //get exam
        $exam = Exam::with('position', 'position.level')
                ->where('id', $request->exam_id)
                ->first();

        if($exam) {

            //get exam session
            $exam_session = ExamSession::where('exam_id', $exam->id)->first();

            //get grades / nilai
            $grades = Grade::with('participant', 'exam.position', 'exam.position.level', 'exam_session')
                    ->where('exam_id', $exam->id)
                    ->where('exam_session_id', $exam_session->id)
                    ->get();

        } else {
            $grades = [];
        }

        return inertia('Admin/Reports/Index', [
            'exams'         => $exams,
            'grades'         => $grades,
        ]);

    }

    /**
     * export
     *
     * @param  mixed $request
     * @return void
     */
    public function export(Request $request)
    {
        //get exam
        $exam = Exam::with('position', 'position.level')
                ->where('id', $request->exam_id)
                ->first();

        //get exam session
        $exam_session = ExamSession::where('exam_id', $exam->id)->first();

        //get grades / nilai
        $grades = Grade::with('participant', 'exam.position', 'exam.position.level', 'exam_session')
                ->where('exam_id', $exam->id)
                ->where('exam_session_id', $exam_session->id)
                ->get();

        return Excel::download(new GradesExport($grades), 'grade : '.$exam->title.' — '.$exam->level->title.' — '.Carbon::now().'.xlsx');
    }
}
