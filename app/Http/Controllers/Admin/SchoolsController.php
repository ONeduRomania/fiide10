<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SchoolsStoreRequest;
use App\Models\Invite;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class SchoolsController extends Controller
{
    public const PER_PAGE = 10;
    public const DELETED_PER_PAGE = 10;

    /**
     * The method shows the index page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $page = $request->get('page', '1');
        $schools = School::allWithCache(Carbon::now()->addMinutes(5), SchoolsController::PER_PAGE, $page);

        return view('dashboard.admin.schools.index', compact('schools'));
    }

    /**
     * This method stores a school
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SchoolsStoreRequest $request) {
        try {
            $school = School::create([
                'name' => $request->name,
                'email_contact' => $request->email_contact,
                'address' => json_encode(['address' => $request->address_type, 'phone_number' => $request->phone_number]),
            ]);
            Invite::create(['school_id' => $school->id, 'code' => Str::substr(Crypt::encryptString($school->name . 'teacher'), 0, 127), 'action' => 1]);

        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return back()->with([
            'success' => __('Școala a fost creată cu succes.'),
            'school' => $school
        ]);
    }

    /**
     * This method handles the editing process of a school in the admin dashboard
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SchoolsStoreRequest $request, School $school) {
        try {
            $schoolUpdated = $school->update([
                'name' => $request->name,
                'email_contact' => $request->email_contact,
                'address' => json_encode(['address' => $request->address_type, 'phone_number' => $request->phone_number]),
            ]);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return back()->with([
            'success' => __('Școala a fost actualizată cu succes.'),
            'school' => $schoolUpdated
        ]);
    }

    /**
     * The page to show the user's details and edit them...
     *
     * @param School $school
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(School $school) {
        return view('dashboard.admin.schools.show', compact('school'));
    }

    /**
     * The destroy method to delete the user...
     *
     * @param School $school
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(School $school) {
        try {
            $school->delete();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return back()->with([
            'success' => __('Școala a fost ștearsă cu succes.')
        ]);
    }

    /**
     * This function is it used to show the deleted users view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleted() {
        $schools = School::onlyTrashed()->paginate(SchoolsController::DELETED_PER_PAGE);

        return view('dashboard.admin.schools.deleted', compact('schools'));
    }

    /**
     * This method is used to force delete an entity which is soft deleted...
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(int $id) {
        try {
            $school = School::withTrashed()->findOrFail($id);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $school->forceDelete();

        return back()->with([
            'success' => __('Utilizatorul a fost complet eliminat.')
        ]);
    }

    /**
     * This function is used to restore a user from the soft deleted list...
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(int $id) {
        try {
            $school = School::withTrashed()->findOrFail($id);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $school->restore();

        return back()->with([
            'success' => __('Școala a fost restaurată cu succes.')
        ]);
    }
}
