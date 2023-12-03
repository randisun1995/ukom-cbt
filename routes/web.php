<?php

use Illuminate\Support\Facades\Route;


//prefix "admin"
Route::prefix('admin')->group(function() {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {

        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');
        //route resource levels
        Route::resource('/levels', \App\Http\Controllers\Admin\LevelController::class, ['as' => 'admin']);
        //route resource positions
        Route::resource('/positions', \App\Http\Controllers\Admin\PositionController::class, ['as' => 'admin']);
        //route student import
        Route::get('/participants/import', [\App\Http\Controllers\Admin\ParticipantController::class, 'import'])->name('admin.participants.import');
        //route student store import
        Route::post('/participants/import', [\App\Http\Controllers\Admin\ParticipantController::class, 'storeImport'])->name('admin.participants.storeImport');
        //route resource participants
        Route::resource('/participants', \App\Http\Controllers\Admin\ParticipantController::class, ['as' => 'admin']);
        //route questions import
        Route::get('questions/import', [\App\Http\Controllers\Admin\QuesController::class, 'import'])->name('admin.questionImport');
        //route questions import
        Route::post('questions/import', [\App\Http\Controllers\Admin\QuesController::class, 'storeImport'])->name('admin.questionStoreImport');
         //route resource question
        Route::resource('/questions', \App\Http\Controllers\Admin\QuesController::class, ['as' => 'admin']);
          //route resource exams
        Route::resource('/exams', \App\Http\Controllers\Admin\ExamController::class, ['as' => 'admin']);
         //custom route for create question exam
        Route::get('/exams/{exam}/questions/create', [\App\Http\Controllers\Admin\ExamController::class, 'createQuestion'])->name('admin.exams.createQuestion');
         //custom route for store question exam
        Route::post('/exams/{exam}/questions/store', [\App\Http\Controllers\Admin\ExamController::class, 'storeQuestion'])->name('admin.exams.storeQuestion');
        //custom route for edit question exam
        Route::get('/exams/{exam}/questions/{question}/edit', [\App\Http\Controllers\Admin\ExamController::class, 'editQuestion'])->name('admin.exams.editQuestion');
         //custom route for update question exam
        Route::put('/exams/{exam}/questions/{question}/update', [\App\Http\Controllers\Admin\ExamController::class, 'updateQuestion'])->name('admin.exams.updateQuestion');
        //custom route for destroy question exam
        Route::delete('/exams/{exam}/questions/{question}/destroy', [\App\Http\Controllers\Admin\ExamController::class, 'destroyQuestion'])->name('admin.exams.destroyQuestion');
        //route questions import
        Route::get('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'import'])->name('admin.exam.questionImport');
        //route questions import
        Route::post('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'storeImport'])->name('admin.exam.questionStoreImport');
        //route resource exam_sessions
        Route::resource('/exam_sessions', \App\Http\Controllers\Admin\ExamSessionController::class, ['as' => 'admin']);
        //custom route for enrolle create
        Route::get('/exam_sessions/{exam_session}/enrolle/create', [\App\Http\Controllers\Admin\ExamSessionController::class, 'createEnrolle'])->name('admin.exam_sessions.createEnrolle');
        //custom route for enrolle store
        Route::post('/exam_sessions/{exam_session}/enrolle/store', [\App\Http\Controllers\Admin\ExamSessionController::class, 'storeEnrolle'])->name('admin.exam_sessions.storeEnrolle');
        //custom route for enrolle destroy
        Route::delete('/exam_sessions/{exam_session}/enrolle/{exam_group}/destroy', [\App\Http\Controllers\Admin\ExamSessionController::class, 'destroyEnrolle'])->name('admin.exam_sessions.destroyEnrolle');
        //route index reports
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
        //route index reports filter
        Route::get('/reports/filter', [\App\Http\Controllers\Admin\ReportController::class, 'filter'])->name('admin.reports.filter');
        //route index reports export
        Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');
         //route resource levels
         Route::resource('/examiners', \App\Http\Controllers\Admin\ExaminerController::class, ['as' => 'admin']);
         //custom route for enrolle create
         Route::get('/examiners/{examiner}/enrolle/create', [\App\Http\Controllers\Admin\ExaminerController::class, 'createEnrolle'])->name('admin.examiners.createEnrolle');
        //custom route for enrolle store
        Route::post('/examiners/{examiner}/enrolle/store', [\App\Http\Controllers\Admin\ExaminerController::class, 'storeEnrolle'])->name('admin.examiners.storeEnrolle');
        //custom route for enrolle destroy
        Route::delete('/examiners/{examiner}/enrolle/{examiner_group}/destroy', [\App\Http\Controllers\Admin\ExaminerController::class, 'destroyEnrolle'])->name('admin.examiners.destroyEnrolle');
        //route resource Indicator
        Route::resource('/indicators', \App\Http\Controllers\Admin\IndicatorController::class, ['as' => 'admin']);
        //route resource Indicator
        Route::resource('/indicators/cathegory', \App\Http\Controllers\Admin\IndicatorCathegoryController::class, ['as' => 'admin']);
        //route resource sertifikat
        Route::resource('/certificates', \App\Http\Controllers\Admin\CertificateController::class, ['as' => 'admin']);
    });
});

//route login participants
Route::get('/', function () {
    //cek session participants
    if(auth()->guard('participant')->check()) {
        return redirect()->route('participant.dashboard');
    }
    //return view login
    return \Inertia\Inertia::render('Participant/Login/Index');
});


//login participants
Route::post('/participants/login', \App\Http\Controllers\Participant\LoginController::class)->name('participant.login');

//prefix "participant"
Route::prefix('participant')->group(function() {

    //middleware "participant"
    Route::group(['middleware' => 'participant'], function () {

        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Participant\DashboardController::class)->name('participant.dashboard');

         //route sertifikat
         Route::get('/certificate', App\Http\Controllers\Participant\CertificateController::class)->name('participant.certificate');

        //route exam confirmation
        Route::get('/exam-confirmation/{id}', [App\Http\Controllers\Participant\ExamController::class, 'confirmation'])->name('participant.exams.confirmation');

        //route exam start
        Route::get('/exam-start/{id}', [App\Http\Controllers\Participant\ExamController::class, 'startExam'])->name('participant.exams.startExam');

         //route exam show
         Route::get('/exam/{id}/{page}', [App\Http\Controllers\Participant\ExamController::class, 'show'])->name('participant.exams.show');
          //route exam update duration
        Route::put('/exam-duration/update/{grade_id}', [App\Http\Controllers\Participant\ExamController::class, 'updateDuration'])->name('participant.exams.update_duration');
        //route answer question
        Route::post('/exam-answer', [App\Http\Controllers\Participant\ExamController::class, 'answerQuestion'])->name('participant.exams.answerQuestion');

        //route exam end
        Route::post('/exam-end', [App\Http\Controllers\Participant\ExamController::class, 'endExam'])->name('participant.exams.endExam');
        //route exam result
        Route::get('/exam-result/{exam_group_id}', [App\Http\Controllers\Participant\ExamController::class, 'resultExam'])->name('participant.exams.resultExam');

    });

});

//route homepage
Route::get('/examiners', function () {
    //cek session participants
    if(auth()->guard('examiner')->check()) {
        return redirect()->route('examiners.dashboard');
    }
    //return view login
    return \Inertia\Inertia::render('Examiners/Login/Index');
});

//login examiners
Route::post('/examiners/login', \App\Http\Controllers\Examiner\LoginController::class)->name('examiners.login');
Route::prefix('examiners')->group(function() {
Route::get('/dashboard', App\Http\Controllers\Examiner\DashboardController::class)->name('examiners.dashboard');
// Route::get('/interviews/{id}', [App\Http\Controllers\Examiner\InterviewController::class, 'grade']);
Route::resource('/interviews', App\Http\Controllers\Examiner\InterviewController::class, ['as' => 'examiner']);
Route::get('/interviews/create/{id}', [App\Http\Controllers\Examiner\InterviewController::class, 'create']);



});
