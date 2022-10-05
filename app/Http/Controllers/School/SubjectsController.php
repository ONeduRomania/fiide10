<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\School\SubjectStoreRequest;
use App\Models\School;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public const PER_PAGE = 5;
    public const DELETED_PER_PAGE = 10;

    public function showSubjects(School $school, Request $request) {
        $school_id = $school->id;
        $subjects = Subject::allWithCache(
            Carbon::now()->addMinutes(5),
            SubjectsController::PER_PAGE,
            $request->get('page', '1'),
            $school->id
        );

        return view('dashboard.school.subject.index', compact('school_id', 'subjects'));
    }

    public function submitSubject(School $school, SubjectStoreRequest $request) {
        try {
            $subject = Subject::create(['name' => $request->name, 'school_id' => $school->id]);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return back()->with([
            'success' => __('Materia a fost adăugată cu succes.'),
            'user' => $subject
        ]);
    }

    public function showSubject(School $school, Subject $subject) {
        return view('dashboard.school.subject.show', compact('school', 'subject'));
    }

    public function updateSubject(School $school, Subject $subject, SubjectStoreRequest $request) {
        try {
            $subject->update(['name' => $request->name, 'school_id' => $school->id]);
        } catch (\Exception $exception) {
            return redirect()->route('subjects.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('subjects.index',  $school->id)->with([
            'success' => __('Materia a fost actualizată cu succes.'),
            'user' => $subject
        ]);
    }

    public function destroySubject(School $school, Subject $subject)
    {
        try {
            $subject->delete();
        } catch (\Exception $exception) {
            return redirect()->route('subjects.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('subjects.index',  $school->id)->with([
            'success' => __('Această materie a fost eliminată.')
        ]);
    }
}

