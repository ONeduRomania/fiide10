<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Teacher;
use App\Request;
use Carbon\Carbon;

class InviteController extends Controller
{
    public function invite(string $code, \Illuminate\Http\Request $request)
    {
        // @todo: In momentul in care cineva este student la o clasa sau este profesor la acceeasi scoala sa nu se puna.
        $invite = Invite::where(['code' => $code])->firstOrFail();
        $teacher = Teacher::where(['user_id' => $request->user()->id, 'school_id' => $invite->school_id])->first();

        if ($teacher) 
            return redirect()->route('home');

        try {
            $request = Request::firstOrCreate(
                ['invite_id' => $invite->id],
                ['invite_id' => $invite->id, 'user_id' => $request->user()->id, 'approved' => NULL, 'declined' => NULL]
            );

            if (Carbon::parse($request->declined)->addMinutes(5) < Carbon::now() && $request->declined !== NULL) {
                $request->update(['declined' => NULL]);
            }

            if (Carbon::parse($request->approved)->addMinutes(5) < Carbon::now() && $request->approved !== NULL) {
                $request->update(['approved' => NULL]);
            }
        } catch (\Exception $e) {
            return abort(404);
        }

        return redirect()->route('home');
    }
}