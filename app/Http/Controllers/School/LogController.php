<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Log\StoreAbsRequest;
use App\Models\Classroom;
use App\Models\Log;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;

class LogController extends Controller
{
    private const ABSENCE_CONST = 1;
    private const MARK_CONST = 2;

    public function create(School $school, Classroom $class)
    {
        $students = Student::where('class_id', $class->id)->get();
        $subjects = Subject::allCached(\Carbon\Carbon::now()->addMinutes(5), $school->id);

        return view('dashboard.school.class.log.new', compact('students', 'school', 'class', 'subjects'));
    }

    public function store(School $school, Classroom $class, StoreAbsRequest $request)
    {
        try {
            $logData = [
                'subject' => $request->subject,
                'type' => $request->markSwitch === "absence" ? self::ABSENCE_CONST : self::MARK_CONST,
                'student' => $request->student,
                'teacher' => $request->user()->id,
                'date' => $request->date
            ];

            if ($logData['type'] === self::MARK_CONST) {
                $logData['mark'] = $request->mark;
            }

            Log::create($logData);
        } catch (\Exception $exception) {
            return redirect()->route('log.create', ['school' => $school->id, 'class' => $class->id])->withErrors($exception->getMessage())->withInput();
        }

        return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Ai adăugat cu succes intrarea în catalog.')
        ]);
    }

    public function destroy(School $school, Classroom $class, Log $log)
    {
        try {
            $log->delete();
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
        return response()->json(['message' => 'Ok']);
    }

    public function studentShow(School $school, Classroom $class, Student $student)
    {
        $logs = Log::where('student', $student->user_id)->get();
        $subjects = Subject::allCached(\Carbon\Carbon::now()->addMinutes(5), $school->id);


        $subjectMarks = [];
        $subjectAbsences = [];
        $subjectMean = [];

        foreach ($subjects as $subject) {
            $subjectMarks[$subject->id] = $logs->filter(function (Log $log) use ($subject) {
                return $log->subject == $subject->id && $log->type == self::MARK_CONST;
            });
            $subjectAbsences[$subject->id] = $logs->filter(function (Log $log) use ($subject) {
                return $log->subject == $subject->id && $log->type == self::ABSENCE_CONST;
            })->count();

            $markCount = count($subjectMarks[$subject->id]);
            if ($markCount === 0) {
                $subjectMean[$subject->id] = 0;
            } else {
                $actualMean = ($subjectMarks[$subject->id]->sum(function (Log $log) {
                        return $log->mark;
                    })) / $markCount;
                $subjectMean[$subject->id] = round($actualMean, 2);
            }
        }

        return view('dashboard.school.class.student', compact('logs', 'student', 'school', 'class', 'subjects', 'subjectMarks', 'subjectMean', 'subjectAbsences'));
    }
}
