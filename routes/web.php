<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\School\ClassController;
use App\Http\Controllers\School\HomeworkController;
use App\Http\Controllers\School\LogController;
use App\Http\Controllers\School\SubjectsController;
use App\Http\Controllers\School\TeacherController;
use App\Http\Controllers\School\TimetableController;
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
    ->name('welcome')
;

Route::prefix('/legal')->group(function () {
    Route::view('/terms', 'legal.terms')
        ->name('legal.terms')
    ;

    Route::view('/privacy', 'legal.privacy')
        ->name('legal.privacy')
    ;

    Route::view('/rules', 'legal.rules')
        ->name('legal.rules')
    ;
});

Auth::routes(['verify' => true, 'logout' => false]);
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

Route::middleware(['verified', 'auth'])->group(function () {
    Route::get('/home', 'HomeController@index')
        ->name('home')
    ;

    Route::get('/invite/{code}', 'InviteController@invite')->name('invite.link');

    Route::namespace('Admin')->prefix('/admin')->group(function () {
        Route::get('/users/deleted', 'UsersController@deleted')->name('users.deleted');
        Route::resource('/users', UsersController::class);

        Route::delete('/users/force/{id}', 'UsersController@forceDelete')->name('users.force');
        Route::match(['PUT', 'PATCH'], '/users/restore/{id}', 'UsersController@restore')->name('users.restore');

        Route::get('/schools/deleted', 'SchoolsController@deleted')->name('schools.deleted');
        Route::resource('/schools', 'SchoolsController');

        Route::delete('/schools/force/{id}', 'SchoolsController@forceDelete')->name('schools.force');
        Route::match(['PUT', 'PATCH'], '/schools/restore/{id}', 'SchoolsController@restore')->name('schools.restore');
    });

    Route::namespace('School')->prefix('/school')->group(function () {
        // region Rutele pentru a adăuga clase noi + modulul de catalog.
        Route::resource('/{school}/classes', ClassController::class);
        Route::match(['PUT', 'PATCH'], '/{school}/classes/{class}/renew', 'ClassController@updateCode')->name('classes.renew');
        Route::delete('/{school}/classes/{class}/request/{request}', 'ClassController@removeRequest')->name('classes.removerequest');
        Route::match(['PUT', 'PATCH'], '/{school}/classes/{class}/request/{request}', 'ClassController@acceptRequest')->name('classes.acceptrequest');
        Route::delete('/{school}/classes/{class}/studentDelete/{student}', 'ClassController@removeStudent')->name('classes.student.destroy');
        Route::get('/{school}/classes/{class}/student/{student}', 'LogController@studentShow')->name('classes.student.show');
        Route::resource('/{school}/classes/{class}/log', LogController::class);
        // endregion

        // region Rutele de a putea adauga profesori si de a selecta o materie
        Route::match(['PUT', 'PATCH'], '/{school}/teachers/renew', 'TeacherController@updateCode')->name('teachers.renew');
        Route::match(['PUT', 'PATCH'], '/{school}/teachers/{request}/request', 'TeacherController@acceptRequest')->name('teachers.acceptrequest');
        Route::delete('/{school}/teachers/{request}/request', 'TeacherController@removeRequest')->name('teachers.removerequest');
        Route::get('/{school}/teachers/timetable', 'TeacherController@timetable')->name('teachers.timetable');
        Route::resource('/{school}/teachers', TeacherController::class);
        // endregion

        // region Rutele de materii
        Route::resource('/{school}/subjects', SubjectsController::class);
        // endregion

        // region Rutele de orar
        Route::resource('/{school}/classes/{class}/timetable', TimetableController::class);
        // endregion

        // region Rutele de teme
        Route::get('/{school}/classes/{class}/homework/current', [HomeworkController::class, 'getHomeworkForStudent'])->name('homework.show_student_homework');
        Route::get('/{school}/classes/{class}/homework/{homework}/submissions/{submission}/download', [HomeworkController::class, 'downloadHomeworkFiles'])->name('homework.download_submission');
        Route::get('/{school}/classes/{class}/homework/{homework}/submit', [HomeworkController::class, 'submitHomework'])->name('homework.submit_get');
        Route::post('/{school}/classes/{class}/homework/{homework}/submit', [HomeworkController::class, 'turnIn'])->name('homework.submit_post');
        Route::post('/{school}/classes/{class}/homework/{homework}/submit/delete', [HomeworkController::class, 'deleteFileFromSubmission'])->name('homework.submit_delete_file');
        Route::resource('/{school}/classes/{class}/homework', HomeworkController::class);
        // endregion
    });
});
