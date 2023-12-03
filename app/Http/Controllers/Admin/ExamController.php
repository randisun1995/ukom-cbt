<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Position;
use App\Models\Question;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get exams
        $exams = Exam::when(request()->q, function($exams) {
            $exams = $exams->where('title', 'like', '%'. request()->q . '%');
        })->with('position','position.level', 'questions')->latest()->paginate(5);

        //append query string to pagination links
        $exams->appends(['q' => request()->q]);
        //render with inertia
        return inertia('Admin/Exams/Index', [
            'exams' => $exams,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //get positions
        $positions = Position::with('level')->get();

        //render with inertia
        return inertia('Admin/Exams/Create', [
            'positions' => $positions,
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
            'title'             => 'required',
            'position_id'       => 'required|integer',
            'duration'          => 'required|integer',
            'description'       => 'required',
            'random_question'   => 'required',
            'random_answer'     => 'required',
            'show_answer'       => 'required',
            'type'              => 'required',
        ]);

        //create exam
        Exam::create([
            'title'             => $request->title,
            'position_id'       => $request->position_id,
            'duration'          => $request->duration,
            'description'       => $request->description,
            'random_question'   => $request->random_question,
            'random_answer'     => $request->random_answer,
            'show_answer'       => $request->show_answer,
            'type'              => $request->type,
        ]);

        //redirect
        return redirect()->route('admin.exams.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get exam
        $exam = Exam::with('position','position.level')->findOrFail($id);

        //get relation questions with pagination
        $exam->setRelation('questions', $exam->questions()->paginate(5));

        //render with inertia
        return inertia('Admin/Exams/Show', [
            'exam' => $exam,
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
        //get exam
        $exam = Exam::findOrFail($id);

        //get positions
        $positions = Position::with('level')->get();
        //render with inertia
        return inertia('Admin/Exams/Edit', [
            'exam' => $exam,
            'positions' => $positions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        //validate request
        $request->validate([
            'title'             => 'required',
            'position_id'       => 'required|integer',
            'duration'          => 'required|integer',
            'description'       => 'required',
            'random_question'   => 'required',
            'random_answer'     => 'required',
            'show_answer'       => 'required',
            'type'              => 'required',
        ]);

        //update exam
        $exam->update([
            'title'             => $request->title,
            'position_id'       => $request->position_id,
            'duration'          => $request->duration,
            'description'       => $request->description,
            'random_question'   => $request->random_question,
            'random_answer'     => $request->random_answer,
            'show_answer'       => $request->show_answer,
            'type'              => $request->type,
        ]);

        //redirect
        return redirect()->route('admin.exams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get exam
        $exam = Exam::findOrFail($id);

        //delete exam
        $exam->delete();

        //redirect
        return redirect()->route('admin.exams.index');
    }

    /**
     * createQuestion
     *
     * @param  mixed $exam
     * @return void
     */
    public function createQuestion(Exam $exam)
    {
        //render with inertia
        return inertia('Admin/Questions/Create', [
            'exam' => $exam,
        ]);
    }

    /**
     * storeQuestion
     *
     * @param  mixed $request
     * @param  mixed $exam
     * @return void
     */
    public function storeQuestion(Request $request, Exam $exam)
    {
        if ($exam->type !== 'Teks'){
            //validate request
            $request->validate([
                'question'          => 'required',
                'option_1'          => 'required',
                'option_2'          => 'required',
                'option_3'          => 'required',
                'option_4'          => 'required',
                'option_5'          => 'required',
                'type'              => 'required',
                'level'             => 'required',
                'difficulty'        => 'required',
                'answer'            => 'required',

            ]);

            //create question
            Question::create([
                'exam_id'           => $exam->id,
                'question'          => $request->question,
                'option_1'          => $request->option_1,
                'option_2'          => $request->option_2,
                'option_3'          => $request->option_3,
                'option_4'          => $request->option_4,
                'option_5'          => $request->option_5,
                'type'              => $request->type,
                'level'             => $request->level,
                'difficulty'        => $request->difficulty,
                'answer'            => $request->answer,
            ]);
        } else {

            //validate request
            $request->validate([
                'question'          => 'required',
                'option_1'          => '',
                'option_2'          => '',
                'option_3'          => '',
                'option_4'          => '',
                'option_5'          => '',
                'type'              => '',
                'level'             => '',
                'difficulty'        => '',
                'answer'            => '',

            ]);

            //create question
            Question::create([
                'exam_id'           => $exam->id,
                'question'          => $request->question,
                'option_1'          => $request->option_1,
                'option_2'          => $request->option_2,
                'option_3'          => $request->option_3,
                'option_4'          => $request->option_4,
                'option_5'          => $request->option_5,
                'type'              => $request->type,
                'level'             => $request->level,
                'difficulty'        => $request->difficulty,
                'answer'            => $request->answer,
            ]);

        }

        //redirect
        return redirect()->route('admin.exams.show', $exam->id);
    }

    /**
     * editQuestion
     *
     * @param  mixed $exam
     * @param  mixed $question
     * @return void
     */
    public function editQuestion(Exam $exam, Question $question)
    {
        //render with inertia
        return inertia('Admin/Questions/Edit', [
            'exam' => $exam,
            'question' => $question,
        ]);
    }

/**
     * updateQuestion
     *
     * @param  mixed $request
     * @param  mixed $exam
     * @param  mixed $question
     * @return void
     */
    public function updateQuestion(Request $request, Exam $exam, Question $question)
    {

        if ($exam->type !== 'Teks'){
        //validate request
        $request->validate([
            'question'          => 'required',
            'option_1'          => 'required',
            'option_2'          => 'required',
            'option_3'          => 'required',
            'option_4'          => 'required',
            'option_5'          => 'required',
            'type'              => 'required',
            'level'             => 'required',
            'difficulty'        => 'required',
            'answer'            => 'required',

        ]);

        //update question
        $question->update([
            'question'          => $request->question,
            'option_1'          => $request->option_1,
            'option_2'          => $request->option_2,
            'option_3'          => $request->option_3,
            'option_4'          => $request->option_4,
            'option_5'          => $request->option_5,
            'type'              => $request->type,
            'level'             => $request->level,
            'difficulty'        => $request->difficulty,
            'answer'            => $request->answer,
        ]);
    } else {//validate request
        $request->validate([
            'question'          => 'required',
            'option_1'          => '',
            'option_2'          => '',
            'option_3'          => '',
            'option_4'          => '',
            'option_5'          => '',
            'type'              => '',
            'level'             => '',
            'difficulty'        => '',
            'answer'            => '',

        ]);
//
        //create question
        $question->update([
            'question'          => $request->question,
            'option_1'          => $request->option_1,
            'option_2'          => $request->option_2,
            'option_3'          => $request->option_3,
            'option_4'          => $request->option_4,
            'option_5'          => $request->option_5,
            'type'              => $request->type,
            'level'             => $request->level,
            'difficulty'        => $request->difficulty,
            'answer'            => $request->answer,
        ]);
    }

        //redirect
        return redirect()->route('admin.exams.show', $exam->id);
    }

    /**
     * destroyQuestion
     *
     * @param  mixed $exam
     * @param  mixed $question
     * @return void
     */
    public function destroyQuestion(Exam $exam, Question $question)
    {
        //delete question
        $question->delete();

        //redirect
        return redirect()->route('admin.exams.show', $exam->id);
    }

     /**
     * import
     *
     * @return void
     */
    public function import(Exam $exam)

    {

        return inertia('Admin/Questions/Import', [
            'exam' => $exam
        ]);
    }

    /**
     * storeImport
     *
     * @param  mixed $request
     * @return void
     */
    public function storeImport(Request $request, Exam $exam)
    {

        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);


        // import data

        Excel::import(new QuestionsImport("$exam->id"), $request->file('file'));

        //redirect
        return redirect()->route('admin.exams.show', $exam->id);
    }
}
