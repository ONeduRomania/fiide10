<?php

namespace App\Http\Controllers\School;

/** @models section */
use App\School;
use App\Classroom;
use App\Teacher;
use App\Invite;
use App\Student;
use App\Request as InviteRequest;

/** @utilities section */
use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\StoreClassRequest;

/** @framework section */
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    private const PER_PAGE = 5;

    public function showClasses(School $school, Request $request) {
        $current_page = $request->get('page', '1');
        $classes = Classroom::allWithCache(Carbon::now()->addMinutes(5), self::PER_PAGE, $current_page, $school->id);
        $teachers = Teacher::with('user')->where(['school_id' => $school->id])->get();

        return view('dashboard.school.class.index', compact('classes', 'school', 'teachers'));
    }

    public function submitClass(School $school, StoreClassRequest $request) {
        try {
            $class = Classroom::create(['name' => $request->name, 'master_teacher' => $request->master_teacher, 'school_id' => $school->id]);
            Invite::create(['school_id' => $school->id, 'class_id' => $class->id, 'code' => Str::substr(Crypt::encryptString($school->name . 'student'), 0, 127), 'action' => 2]);
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

    public function classDetails(School $school, Classroom $class, Request $request) {
        $current_page = $request->get('page', '1');
        $current_req_page = $request->get('request_page', '1');

        $teachers = Teacher::with('user')->where(['school_id' => $school->id])->get();
        $invite = Invite::where(['class_id' => $class->id, 'school_id' => $school->id, 'action' => 2])->first();

        $students = Student::allWithCache(Carbon::now()->addMinutes(5), self::PER_PAGE, $current_page, $class->id);
        $requests = InviteRequest::allWithCache(Carbon::now()->addMinutes(5), self::PER_PAGE, $current_req_page, $invite->id);
        return view('dashboard.school.class.show', compact('school', 'class', 'teachers', 'invite', 'requests', 'students'));
    }

    public function updateCode(School $school, Classroom $class) {
        $invite = Invite::where(['school_id' => $school->id, 'class_id' => $class->id, 'action' => 2])->firstOrFail();
        $invite->update(['code' => Str::substr(Crypt::encryptString($school->name . 'student'), 0, 127)]);

        return redirect()->route('classes.show',  ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('The code has been renewed with success, congrats.')
        ]);
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

    public function removeRequest(School $school, Classroom $class, InviteRequest $request) {
        try {
            $request->update(['declined' => Carbon::now()]);
        } catch (\Exception $exception) {
            return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('The request for this student has been declined with success, congrats.')
        ]);
    }

    public function acceptRequest(School $school, Classroom $class, InviteRequest $request) {
        try {
            $request->delete();
        } catch (\Exception $exception) {
            return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->withError($exception->getMessage())->withInput();
        }

        Student::create(['user_id' => $request->user_id, 'class_id' => $class->id]);

        return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('The request for this student has been answered with success, congrats.')
        ]);
    }
}
