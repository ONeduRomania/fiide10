<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Classroom\StoreClassRequest;
use App\Models\Classroom;
use App\Models\Invite;
use App\Models\Request as InviteRequest;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    private const PER_PAGE = 5;

    public function index(School $school, Request $request)
    {
        $current_page = $request->get('page', '1');
        $classes = Classroom::allWithCache(Carbon::now()->addMinutes(5), self::PER_PAGE, $current_page, $school->id);
        $teachers = Teacher::with('user')->where(['school_id' => $school->id])->get();

        return view('dashboard.school.class.index', compact('classes', 'school', 'teachers'));
    }

    public function create(School $school)
    {
        $teachers = Teacher::with('user')->where(['school_id' => $school->id])->get();
        // TODO: Redirect to teachers if array is empty
        return view('dashboard.school.class.new', compact('school', 'teachers'));
    }

    public function edit(School $school, Classroom $class)
    {
        $teachers = Teacher::with('user')->where(['school_id' => $school->id])->get();
        // TODO: Redirect to teachers if array is empty
        return view('dashboard.school.class.edit', compact('school', 'teachers', 'class'));
    }

    public function store(School $school, StoreClassRequest $request)
    {
        try {
            $class = Classroom::create(['name' => $request->name, 'master_teacher' => $request->master_teacher, 'school_id' => $school->id]);
            Invite::create([
                'school_id' => $school->id,
                'class_id' => $class->id,
                'code' => Str::substr(Crypt::encryptString($school->name . 'student'), 0, 127),
                'action' => 2
            ]);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('classes.show', ['class' => $class->id, 'school' => $school->id])->with([
            'success' => __('Clasa a fost creată cu succes.')
        ]);
    }

    public function destroy(School $school, Classroom $class)
    {
        try {
            $class->delete();
        } catch (\Exception $exception) {
            return redirect()->route('classes.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('classes.index', $school->id)->with([
            'success' => __('Clasa a fost ștearsă.')
        ]);
    }

    public function show(School $school, Classroom $class, Request $request)
    {
        $current_page = $request->get('page', '1');
        $current_req_page = $request->get('request_page', '1');

        $teachers = Teacher::with('user')->where(['school_id' => $school->id])->get();
        $invite = Invite::where(['class_id' => $class->id, 'school_id' => $school->id, 'action' => 2])->first();

        $students = Student::allWithCache(Carbon::now()->addMinutes(5), self::PER_PAGE, $current_page, $class->id);
        $requests = InviteRequest::allWithCache(Carbon::now()->addMinutes(5), self::PER_PAGE, $current_req_page, $invite->id);
        return view('dashboard.school.class.show', compact('school', 'class', 'teachers', 'invite', 'requests', 'students'));
    }

    public function updateCode(School $school, Classroom $class)
    {
        $invite = Invite::where(['school_id' => $school->id, 'class_id' => $class->id, 'action' => 2])->firstOrFail();
        $invite->update(['code' => Str::substr(Crypt::encryptString($school->name . 'student'), 0, 127)]);

        return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Codul a fost reînnoit.')
        ]);
    }

    public function update(School $school, Classroom $class, StoreClassRequest $request)
    {
        try {
            $class->update(['name' => $request->name, 'master_teacher' => $request->master_teacher]);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Clasa a fost actualizată cu succes.')
        ]);
    }

    public function removeRequest(School $school, Classroom $class, InviteRequest $request)
    {
        try {
            $request->update(['declined' => Carbon::now()]);
        } catch (\Exception $exception) {
            return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Solicitarea elevului de a se alătura clasei a fost eliminată definitiv.')
        ]);
    }

    public function acceptRequest(School $school, Classroom $class, InviteRequest $request)
    {
        try {
            $request->delete();
        } catch (\Exception $exception) {
            return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->withError($exception->getMessage())->withInput();
        }

        Student::create(['user_id' => $request->user_id, 'class_id' => $class->id]);

        return redirect()->route('classes.show', ['school' => $school->id, 'class' => $class->id])->with([
            'success' => __('Felicitări! Ai un nou elev :)')
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
}
