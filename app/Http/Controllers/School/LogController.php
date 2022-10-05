<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Log\StoreAbsRequest;
use App\Http\Requests\Log\StoreMarkRequest;
use App\Models\Classroom;
use App\Models\Log;
use App\Models\School;
use App\Models\Student;
use App\Models\Subject;

class LogController extends Controller
{
    private const ABSENCE_CONST = 1;
    private const MARK_CONST = 2;

    public function showLogs(School $school, Classroom $class) {
        $students = Student::where('class_id', $class->id)->get();
        $subjects = Subject::allCached(\Carbon\Carbon::now()->addMinutes(5), $school->id);

        return view('dashboard.school.class.log', compact('students', 'school', 'class', 'subjects'));
    }

    public function createAbsenceLog(School $school, Classroom $class, StoreAbsRequest $request) {
        try {
            Log::create([
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

    public function createMarkLog(School $school, Classroom $class, StoreMarkRequest $request) {
        try {
            Log::create([
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

    public function removeStudent(School $school, Classroom $class, Student $student) {
        try {
            $student->delete();
        } catch (\Exception $exception) {
            return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->withErrors($exception->getMessage())->withInput();
        }
        return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('The student has been deleted with success, congrats.')
        ]);
    }

    public function deleteLog(School $school, Classroom $class, Log $log) {
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

    public function studentShow(School $school, Classroom $class, Student $student) {
        $logs = Log::where('student', $student->user_id)->get();
        $subjects = Subject::allCached(\Carbon\Carbon::now()->addMinutes(5), $school->id);

        return view('dashboard.school.class.student', compact('logs', 'student', 'school', 'class', 'subjects'));
    }
}
