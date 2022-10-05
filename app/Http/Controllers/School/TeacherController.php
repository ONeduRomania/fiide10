<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\TeacherSubjectRequest;
use App\Models\Invite;
use App\Models\Request as InviteRequest;
use App\Models\School;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    private const PER_PAGE = 5;

    public function index(School $school, Request $request) {
        $current_page = $request->get('page', '1');
        $current_req_page = $request->get('request_page', '1');

        $invite = Invite::where(['school_id' => $school->id, 'action' => 1])->firstOrFail();
        $requests = InviteRequest::allWithCache(Carbon::now()->addMinutes(5), self::PER_PAGE, $current_req_page, $invite->id);
        $teachers = Teacher::allWithCache(Carbon::now()->addMinutes(5), self::PER_PAGE, $current_page, $school->id);

        return view('dashboard.school.teacher.index', compact('teachers', 'school', 'requests', 'invite'));
    }

    public function removeTeacher(School $school, Teacher $teacher) {
        try {
            $teacher->delete();
        } catch(\Exception $exception) {
            return redirect()->route('teachers.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('teachers.index',  $school->id)->with([
            'success' => __('Profesorul a fost eliminat cu succes.')
        ]);
    }

    public function updateCode(School $school) {
        $invite = Invite::where(['school_id' => $school->id, 'action' => 1])->firstOrFail();
        $invite->update(['code' => Str::substr(Crypt::encryptString($school->name . 'teacher'), 0, 127)]);

        return redirect()->route('teachers.index',  $school->id)->with([
            'success' => __('Codul a fost reînoit.')
        ]);
    }

    public function teacherDetails(School $school, Teacher $teacher) {
        $subjects = Subject::allCached(Carbon::now()->addMinutes(5), $school->id);
        return view('dashboard.school.teacher.show', compact('school', 'teacher', 'subjects'));
    }

    public function teacherUpdate(School $school, Teacher $teacher, TeacherSubjectRequest $request) {
        try {
            TeacherSubject::updateOrCreate(
                ['teacher_id' => $teacher->id, 'subject_id' => $request->subject],
                ['teacher_id' => $teacher->id, 'subject_id' => $request->subject]
            );
        } catch (\Exception $exception) {
            return redirect()->route('teachers.show', ['school' => $school->id, 'teacher' => $teacher->id])->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('teachers.show', ['school' => $school->id, 'teacher' => $teacher->id])->with([
            'message' => __('Contul profesorului a fost actualizat cu succes.')
        ]);
    }

    public function deleteTeacher(School $school, Teacher $teacher) {
        try {
            $teacher->delete();
        } catch (\Exception $exception) {
            return redirect()->route('teachers.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('teachers.index',  $school->id)->with([
            'success' => __('Profesorul a fost eliminat din școală.')
        ]);
    }

    public function removeRequest(School $school, InviteRequest $request) {
        try {
            $request->update(['declined' => Carbon::now()]);
        } catch (\Exception $exception) {
            return redirect()->route('teachers.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('teachers.index',  $school->id)->with([
            'success' => __('Solicitarea profesorului de a se alătura clasei a fost înlăturată cu succes.')
        ]);
    }

    public function acceptRequest(School $school, InviteRequest $request) {
        try {
            $request->delete();
        } catch (\Exception $exception) {
            return redirect()->route('teachers.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        Teacher::create(['user_id' => $request->user_id, 'school_id' => $school->id]);

        return redirect()->route('teachers.index',  $school->id)->with([
            'success' => __('Felicitări! Un nou profesor s-a alăturat școlii.')
        ]);
    }
}

