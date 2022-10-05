<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timetable\StoreTimetableRequest;
use App\Models\Classroom;
use App\Models\School;
use App\Models\Subject;
use App\Models\Timetable;

class TimetableController extends Controller
{
    public function showTimetable(School $school, Classroom $class) {
        $timetables = Timetable::with('subjects')->where('class_id', $class->id)->orderBy('id', 'DESC')->get();
        $subjects = Subject::where('school_id', $school->id)->get();

        return view('dashboard.school.class.timetable.index', compact('school', 'class', 'timetables', 'subjects'));
    }

    public function checkTimetable(School $school, Classroom $class, Timetable $timetable) {
        $subjects = Subject::where('school_id', $school->id)->get();

        return view('dashboard.school.class.timetable.show', compact('school', 'class', 'timetable', 'subjects'));
    }

    public function createTimetable(School $school, Classroom $class, StoreTimetableRequest $request) {
        try {
            Timetable::create([
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

    public function updateTimetable(School $school, Classroom $class, Timetable $timetable, StoreTimetableRequest $request) {
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

    public function deleteTimetable(School $school, Classroom $class, Timetable $timetable) {
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
