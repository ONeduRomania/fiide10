<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Requests\InviteCodeRequest;

use App\Teacher;
use App\School;
use App\Request as InviteRequest;
use App\Invite;
use App\Subject;

use Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller 
{
    private const PER_PAGE = 5;
    private const DELETED_PER_PAGE = 10;

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
        } catch(\Exception $e) {
            return redirect()->route('teachers.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('teachers.index',  $school->id)->with([
            'success' => __('The teacher has been removed with success, congrats.')
        ]);
    }

    public function updateCode(School $school) {
        $invite = Invite::where(['school_id' => $school->id, 'action' => 1])->firstOrFail();
        $invite->update(['code' => Str::substr(Crypt::encryptString($school->name . 'teacher'), 0, 127)]);

        return redirect()->route('teachers.index',  $school->id)->with([
            'success' => __('The code has been renewed with success, congrats.')
        ]);
    }

    public function teacherDetails(School $school, Teacher $teacher) {
        $subjects = Subject::allCached(Carbon::now()->addMinutes(5), $school->id);
        return view('dashboard.school.teacher.show', compact('school', 'teacher', 'subjects'));
    }

    public function updateTeacher(School $school, Teacher $teacher) {
        
    }

    public function deleteTeacher(School $school, Teacher $teacher) {
        try {
            $teacher->delete();
        } catch (\Exception $exception) {
            return redirect()->route('teachers.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('teachers.index',  $school->id)->with([
            'success' => __('The teacher has been removed with success, congrats.')
        ]);
    }

    public function removeRequest(School $school, InviteRequest $request) {
        try {
            $request->update(['declined' => Carbon::now()]);
        } catch (\Exception $exception) {
            return redirect()->route('teachers.index', $school->id)->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('teachers.index',  $school->id)->with([
            'success' => __('The request for this teacher has been declined with success, congrats.')
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
            'success' => __('The request for this teacher has been answered with success, congrats.')
        ]);
    }
}

