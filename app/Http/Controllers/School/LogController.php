<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Log\StoreAbsRequest;
use App\Http\Requests\Log\StoreMarkRequest;

class LogController extends Controller
{
    public function showLogs(\App\School $school, \App\Classroom $class) {
        $students = \App\Student::where('class_id', $class->id)->get();
        $subjects = \App\Subject::allCached(\Carbon\Carbon::now()->addMinutes(5), $school->id);

        return view('dashboard.school.class.log', compact('students', 'school', 'class', 'subjects'));
    }

    public function createAbsenceLog(\App\School $school, \App\Classroom $class, \App\Student $student, StoreAbsRequest $request) {
        dd($request->all());
    }

    public function createMarkLog(\App\School $school, \App\Classroom $class, \App\Student $student, StoreMarkRequest $request) {
        dd($request->all());
    }
}
