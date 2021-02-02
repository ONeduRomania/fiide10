<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timetable\StoreTimetableRequest;

class TimetableController extends Controller
{
    public function showTimetable(\App\School $school, \App\Classroom $class) {
        $timetables = \App\Timetable::with('subjects')->where('class_id', $class->id)->orderBy('id', 'DESC')->get();
        $subjects = \App\Subject::where('school_id', $school->id)->get();

        return view('dashboard.school.class.timetable.index', compact('school', 'class', 'timetables', 'subjects'));
    }

    public function checkTimetable(\App\School $school, \App\Classroom $class, \App\Timetable $timetable) {
        $subjects = \App\Subject::where('school_id', $school->id)->get();

        return view('dashboard.school.class.timetable.show', compact('school', 'class', 'timetable', 'subjects'));
    }

    public function createTimetable(\App\School $school, \App\Classroom $class, StoreTimetableRequest $request) {
        try {
            \App\Timetable::create([
                'class_id' => $class->id,
                'subject_id' => $request->subject,
                'data' => json_encode(['startTime' => $request->date_start, 'endTime' => $request->date_end])
            ]);
        } catch (\Exception $exception) {
            return redirect()
                ->route('timetable.show', ['school' => $school->id, 'class' => $class->id])
                ->withErrors($exception->getMessage())
                ->withInput();
        }

        return redirect()->route('timetable.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Orarul a fost actualizat cu succes.')
        ]);
    }

    public function updateTimetable(\App\School $school, \App\Classroom $class, \App\Timetable $timetable, StoreTimetableRequest $request) {
        try {
            $timetable->update([
                'subject_id' => $request->subject,
                'data' => json_encode(['startTime' => $request->date_start, 'endTime' => $request->date_end]),
            ]);
        } catch (\Exception $exception) {
            return redirect()
                ->route('timetable.show', ['school' => $school->id, 'class' => $class->id])
                ->withErrors($exception->getMessage())
                ->withInput();
        }

        return redirect()->route('timetable.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Orarul a fost actualizat cu succes.')
        ]);
    }

    public function deleteTimetable(\App\School $school, \App\Classroom $class, \App\Timetable $timetable) {
        try {
            $timetable->delete();
        } catch (\Exception $exception) {
            return redirect()
                ->route('timetable.show', ['school' => $school->id, 'class' => $class->id])
                ->withErrors($exception->getMessage())
                ->withInput();
        }

        return redirect()->route('timetable.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Orarul a fost șters cu succes.')
        ]);
    }
}
