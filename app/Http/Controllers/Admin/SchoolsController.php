<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SchoolsStoreRequest;
use App\Http\Controllers\Controller;
use App\School;
use App\User;

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
        // @todo: Cand creez sa fac si codul de invite pentru astia
        try {
            $school = School::create([
                'name' => $request->name,
                'email_contact' => $request->email_contact,
                'address' => json_encode(['address' => $request->address_type, 'phone_number' => $request->phone_number]),
            ]);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return back()->with([
            'success' => __('The school has been created with success, congrats.'),
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
            'success' => __('The school has been updated with success, congrats.'),
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
            'success' => __('The school has been deleted with success, congrats.')
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
            'success' => __('The user has been permanently deleted with success, congrats.')
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
            'success' => __('The school has been restored with success, congrats.')
        ]);
    }
}
