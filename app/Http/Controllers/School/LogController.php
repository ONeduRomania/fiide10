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

    public function removeStudent(\App\School $school, \App\Classroom $class, \App\Student $student) {
        try {
            $student->delete();
        } catch (\Exception $exception) {
            return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->withErrors($exception->getMessage())->withInput();
        }
        return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('The student has been deleted with success, congrats.')
        ]);
    }

    public function deleteAbsLog(\App\School $school, \App\Classroom $class, \App\Student $student) {

    }

    public function deleteMarkLog(\App\School $school, \App\Classroom $class, \App\Student $student) {

    }

    public function studentShow(\App\School $school, \App\Classroom $class, \App\Student $student) {

    }
}
