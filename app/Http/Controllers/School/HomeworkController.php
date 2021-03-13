<?php

namespace App\Http\Controllers\School;

use App\Classroom;
use App\Homework;
use App\Http\Controllers\Controller;
use App\Http\Requests\Homework\StoreHomeworkRequest;
use App\School;
use App\Subject;
use App\Teacher;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function getHomeworkForSubject(School $school, Classroom $classroom, Subject $subject, Request $request)
    {
        $homeworks = \App\Homework::withCount('submissions')->where('subject_id', $subject->id)->where('class_id', $classroom->id)->orderBy('id', 'DESC')->get();

        return view('dashboard.school.class.homework.index', compact('school', 'classroom', 'homeworks', 'subject'));

    }

    public function createHomeworkForSubject(School $school, Classroom $classroom, Subject $subject, StoreHomeworkRequest $request): RedirectResponse
    {
        try {

            // Assign the homework to the currently logged in teacher
            /** @var User $currentUser */
            $currentUser = $request->user();
            $teacher = Teacher::where('user_id', $currentUser->id)->get()->first();

            $homework = new Homework();
            $homework->class_id = $classroom->id;
            $homework->subject_id = $subject->id;
            $homework->teacher_id = $teacher->id;
            $homework->due_date = $request->due_date;
            $homework->name = $request->name;
            $homework->save();

        } catch (\Exception $exception) {
            return redirect()
                ->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])
                ->withErrors($exception->getMessage())
                ->withInput();
        }

        return redirect()->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])->with([
            'success' => __('Tema a fost adăugată cu succes.')
        ]);
    }

    public function updateHomework(School $school, Classroom $classroom, Subject $subject, Homework $homework, StoreHomeworkRequest $request) {
        try {
            if ($request->due_date != null) {
                $homework->due_date = $request->due_date;
                // TODO: Trimite notificare pentru data schimbată dacă e cazul
            }

            if ($request->name != null) {
                $homework->name = $request->name;
            }

            $homework->save();
        } catch (\Exception $exception) {
            return redirect()
                ->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])
                ->withErrors($exception->getMessage())
                ->withInput();
        }

        return redirect()->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])->with([
            'success' => __('Tema a fost editată cu succes.')
        ]);
    }

    public function deleteHomework(School $school, Classroom $classroom, Subject $subject, Homework $homework) {
        try {
            $homework->delete();
        } catch (\Exception $exception) {
            return redirect()
                ->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])
                ->withErrors($exception->getMessage())
                ->withInput();
        }

        return redirect()->route('homework.show_all', ['school' => $school->id, 'classroom' => $classroom->id, 'subject' => $subject->id])->with([
            'success' => __('Tema a fost ștearsă cu succes.')
        ]);
    }

    public function checkHomework(School $school, Classroom $classroom, Subject $subject, Homework $homework) {
        return view('dashboard.school.class.homework.show', compact('school', 'classroom', 'homework', 'subject'));
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
