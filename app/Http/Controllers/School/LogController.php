<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Log\StoreAbsRequest;
use App\Http\Requests\Log\StoreMarkRequest;

class LogController extends Controller
{
    private const ABSENCE_CONST = 1;
    private const MARK_CONST = 2;

    public function showLogs(\App\School $school, \App\Classroom $class) {
        $students = \App\Student::where('class_id', $class->id)->get();
        $subjects = \App\Subject::allCached(\Carbon\Carbon::now()->addMinutes(5), $school->id);

        return view('dashboard.school.class.log', compact('students', 'school', 'class', 'subjects'));
    }

    public function createAbsenceLog(\App\School $school, \App\Classroom $class, StoreAbsRequest $request) {
        try {
            \App\Log::create([
                'subject' => $request->subject,
                'type' => self::ABSENCE_CONST,
                'student' => $request->student,
                'teacher' => $request->user()->id,
                'data' => json_encode(['date' => $request->date_absence, 'term' => $request->term, 'deleted' => NULL])
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('classes.log', ['school' => $school->id, 'class' => $class->id])->withErrors($exception->getMessage())->withInput();
        }

        return redirect()->route('classes.log', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('The absence has been added with success, congrats.')
        ]);
    }

    public function createMarkLog(\App\School $school, \App\Classroom $class, StoreMarkRequest $request) {
        try {
            \App\Log::create([
                'subject' => $request->subject,
                'type' => self::MARK_CONST,
                'student' => $request->student,
                'teacher' => $request->user()->id,
                'data' => json_encode(['mark' => $request->mark, 'date' => $request->date, 'term' => $request->term])
            ]);
        } catch (\Exception $exception) {
            return redirect()->route('classes.log', ['school' => $school->id, 'class' => $class->id])->withErrors($exception->getMessage())->withInput();
        }

        return redirect()->route('classes.log', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('The log has been added with success, congrats.')
        ]);
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

    public function deleteLog(\App\School $school, \App\Classroom $class, \App\Log $log) {
        $student_id = $log->student;

        try {
            switch ($log->type) {
                case self::ABSENCE_CONST: {
                    $data = json_decode($log->data);
                    $log->update(['data' => json_encode(['date' => $data->date, 'term' => $data->term, 'deleted' => now()])]);
                    break;
                }
                case self::MARK_CONST: {
                    $log->delete();
                    break;
                }
            }
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
        return response()->json(['message' => 'Ok']);
    }

    public function studentShow(\App\School $school, \App\Classroom $class, \App\Student $student) {
        $logs = \App\Log::where('student', $student->user_id)->get();
        $subjects = \App\Subject::allCached(\Carbon\Carbon::now()->addMinutes(5), $school->id);

        return view('dashboard.school.class.student', compact('logs', 'student', 'school', 'class', 'subjects'));
    }
}
