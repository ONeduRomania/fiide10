<?php

use App\Http\Controllers\School\HomeworkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome')
    ->name('welcome');

Route::prefix('/legal')->group(function () {
   Route::view('/terms', 'legal.terms')
       ->name('legal.terms');

    Route::view('/privacy', 'legal.privacy')
        ->name('legal.privacy');

    Route::view('/rules', 'legal.rules')
        ->name('legal.rules');
});

Auth::routes(['verify' => true]);

Route::middleware(['verified', 'auth'])->group(function () {
    Route::get('/home', 'HomeController@index')
        ->name('home');

    Route::get('/invite/{code}', 'InviteController@invite')->name('invite.link');

    Route::namespace('Admin')->prefix('/admin')->group(function () {
        Route::get('/users/deleted', 'UsersController@deleted')->name('users.deleted');
        Route::resource('/users', 'UsersController')->except(['create', 'edit']);

        Route::delete('/users/force/{id}', 'UsersController@forceDelete')->name('users.force');
        Route::match(['PUT', 'PATCH'], '/users/restore/{id}', 'UsersController@restore')->name('users.restore');

        Route::get('/schools/deleted', 'SchoolsController@deleted')->name('schools.deleted');
        Route::resource('/schools', 'SchoolsController')->except(['create', 'edit']);

        Route::delete('/schools/force/{id}', 'SchoolsController@forceDelete')->name('schools.force');
        Route::match(['PUT', 'PATCH'], '/schools/restore/{id}', 'SchoolsController@restore')->name('schools.restore');
    });

    Route::namespace('School')->prefix('/school')->group(function () {
        //region Rutele pentru a adauga clase noi + modulul de catalog.
        Route::get('/{school}/classes', 'ClassController@showClasses')->name('classes.index');
        Route::post('/{school}/classes', 'ClassController@submitClass')->name('classes.submit');
        Route::delete('/{school}/classes/{class}', 'ClassController@removeClass')->name('classes.destroy');
        Route::get('/{school}/classes/{class}/show', 'ClassController@classDetails')->name('classes.show');
        Route::match(['PUT', 'PATCH'], '/{school}/classes/{class}/show', 'ClassController@updateClass')->name('classes.update');
        Route::match(['PUT', 'PATCH'], '/{school}/classes/{class}/renew', 'ClassController@updateCode')->name('classes.renew');
        Route::delete('/{school}/classes/{class}/request/{request}', 'ClassController@removeRequest')->name('classes.removerequest');
        Route::match(['PUT', 'PATCH'], '/{school}/classes/{class}/request/{request}', 'ClassController@acceptRequest')->name('classes.acceptrequest');
        Route::get('/{school}/classes/{class}/log', 'LogController@showLogs')->name('classes.log');
        Route::post('/{school}/classes/{class}/absence', 'LogController@createAbsenceLog')->name('classes.absence');
        Route::post('/{school}/classes/{class}/mark', 'LogController@createMarkLog')->name('classes.mark');
        Route::delete('/{school}/classes/{class}/studentDelete/{student}', 'LogController@removeStudent')->name('classes.student.destroy');
        Route::get('/{school}/classes/{class}/student/{student}', 'LogController@studentShow')->name('classes.student.show');
        Route::delete('/{school}/classes/{class}/log/{log}', 'LogController@deleteLog')->name('log.delete');
        //endregion

        //region Rutele de a putea adauga profesori si de a selecta o materie
        Route::get('/{school}/teachers', 'TeacherController@index')->name('teachers.index');
        Route::delete('/{school}/teachers/{teacher}', 'TeacherController@removeTeacher')->name('teachers.destroy');
        Route::get('/{school}/teachers/{teacher}/show', 'TeacherController@teacherDetails')->name('teachers.show');
        Route::match(['PUT', 'PATCH'], '/{school}/teachers/renew', 'TeacherController@updateCode')->name('teachers.renew');
        Route::match(['PUT', 'PATCH'], '/{school}/teachers/{teacher}/update', 'TeacherController@teacherUpdate')->name('teachers.update');
        Route::delete('/{school}/teacher/{request}/request', 'TeacherController@removeRequest')->name('teachers.removerequest');
        Route::match(['PUT', 'PATCH'], '/{school}/teacher/{request}/request', 'TeacherController@acceptRequest')->name('teachers.acceptrequest');
        //endregion

        //region Rutele de a putea crea o materie noua
        Route::get('/{school}/subjects', 'SubjectsController@showSubjects')->name('subjects.index');
        Route::post('/{school}/subjects', 'SubjectsController@submitSubject')->name('subjects.submit');
        Route::get('/{school}/subjects/{subject}/show', 'SubjectsController@showSubject')->name('subjects.show');
        Route::delete('/{school}/subjects/{subject}/destroy', 'SubjectsController@destroySubject')->name('subjects.destroy');
        Route::match(['PUT', 'PATCH'], '/{school}/subjects/{subject}/update', 'SubjectsController@updateSubject')->name('subjects.update');
        //endregion

        //region Rutele de orar
        Route::get('/{school}/classes/{class}/timetable', 'TimetableController@showTimetable')->name('timetable.show');
        Route::post('/{school}/classes/{class}/timetable', 'TimetableController@createTimetable')->name('timetable.create');
        Route::delete('/{school}/classes/{class}/timetable/{timetable}', 'TimetableController@deleteTimetable')->name('timetable.delete');
        Route::get('/{school}/classes/{class}/timetable/{timetable}/show', 'TimetableController@checkTimetable')->name('timetable.check');
        Route::match(['PUT', 'PATCH'], '/{school}/classes/{class}/timetable/{timetable}', 'TimetableController@updateTimetable')->name('timetable.update');
        //endregion

        //region Rutele de teme
        Route::get('/{school}/classes/{classroom}/homework', [HomeworkController::class, 'getHomeworkForStudent'])->name('homework.show_student_homework');
        Route::get('/{school}/classes/{classroom}/subjects/{subject}/homework', [HomeworkController::class, 'getHomeworkForSubject'])->name('homework.show_all');
        Route::post('/{school}/classes/{classroom}/subjects/{subject}/homework', [HomeworkController::class, 'createHomeworkForSubject'])->name('homework.create');
        Route::delete('/{school}/classes/{classroom}/subjects/{subject}/homework/{homework}', [HomeworkController::class, 'deleteHomework'])->name('homework.delete');
        Route::get('/{school}/classes/{classroom}/subjects/{subject}/homework/{homework}', [HomeworkController::class, 'checkHomework'])->name('homework.check');
        Route::match(['PUT', 'PATCH'],'/{school}/classes/{classroom}/subjects/{subject}/homework/{homework}', [HomeworkController::class, 'updateHomework'])->name('homework.update');
        Route::get('/{school}/classes/{classroom}/subjects/{subject}/homework/{homework}/submissions/{submission}/download', [HomeworkController::class, 'downloadHomeworkFiles'])->name('homework.download_submission');
        Route::get('/{school}/classes/{classroom}/subjects/{subject}/homework/{homework}/submit', [HomeworkController::class, 'submitHomework'])->name('homework.submit_get');
        Route::post('/{school}/classes/{classroom}/subjects/{subject}/homework/{homework}/submit', [HomeworkController::class, 'turnIn'])->name('homework.submit_post');
        Route::post('/{school}/classes/{classroom}/subjects/{subject}/homework/{homework}/submit/delete', [HomeworkController::class, 'deleteFileFromSubmission'])->name('homework.submit_delete_file');
        //endregion
    });
});
