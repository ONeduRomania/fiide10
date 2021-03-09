<?php

namespace App\Http\Controllers\School;

use App\Classroom;
use App\Http\Controllers\Controller;
use App\School;
use App\Subject;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function getHomeworkForSubject(School $school, Classroom $classroom, Subject $subject, Request $request)
    {
        $homeworks = \App\Homework::with('submissions')->where('subject_id', $subject->id)->where('class_id', $classroom->id)->orderBy('id', 'DESC')->get();

        return view('dashboard.school.class.homework.index', compact('school', 'classroom', 'homeworks', 'subject'));

    }

    public function createHomeworkForSubject(School $school, Classroom $classroom, Request $request)
    {
        // TODO: Implement
        $subjectId = $request->get('subject');
        return view('dashboard.school.class.index');

    }

    public function getHomeworkForStudent(School $school, Classroom $classroom, Request $request)
    {
        // TODO: Implement
        $subjectId = $request->get('subject');
        return view('dashboard.school.class.index');

    }

    public function getDueHomeworkFromStudent(School $school, Classroom $classroom, Request $request)
    {
        // TODO: Implement
        $subjectId = $request->get('subject');
        return view('dashboard.school.class.index');

    }

    public function turnIn(School $school, Classroom $classroom, Request $request)
    {
        // TODO: Implement
        $subjectId = $request->get('subject');
        return view('dashboard.school.class.index');

    }
}
