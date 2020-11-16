<?php

namespace App\Http\Controllers\School;

/** @models section */
use App\School;
use App\Classroom;
use App\Teacher;

/** @utilities section */
use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\StoreClassRequest;

/** @framework section */
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClassController extends Controller
{
    private const PER_PAGE = 5;
    private const DELETED_PER_PAGE = 10;

    public function showClasses(School $school, Request $request) {
        $current_page = $request->get('page', '1');
        $classes = Classroom::allWithCache(Carbon::now()->addMinutes(5), self::PER_PAGE, $current_page, $school->id);
        $teachers = Teacher::with('user')->where(['school_id' => $school->id])->get();

        return view('dashboard.school.class.index', compact('classes', 'school', 'teachers'));
    }

    public function submitClass(School $school, StoreClassRequest $request) {
        try {
            Classroom::create(['name' => $request->name, 'master_teacher' => $request->master_teacher, 'school_id' => $school->id]);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return back()->with([
            'success' => __('The classroom has been created with success, congrats.'),
        ]);
    }

    public function removeClass(School $school, Classroom $class) {
        try {
            $class->delete();
        } catch (\Exception $exception) {
            return redirect()->route('classes.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('classes.index', $school->id)->with([
            'success' => __('The classroom has been deleted with success, congrats.')
        ]);
    }

    public function classDetails(School $school, Classroom $class) {
        $teachers = Teacher::with('user')->where(['school_id' => $school->id])->get();

        return view('dashboard.school.class.show', compact('school', 'class', 'teachers'));
    }

    public function updateClass(School $school, Classroom $class, StoreClassRequest $request) {
        try {
            $class->update(['name' => $request->name, 'master_teacher' => $request->master_teacher]);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('The classroom has been updated with success, congrats.')
        ]);
    }
}