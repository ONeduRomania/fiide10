<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SchoolsStoreRequest;
use App\Models\Invite;
use App\Models\School;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SchoolsController extends Controller
{
    public const PER_PAGE = 10;
    public const DELETED_PER_PAGE = 10;

    /**
     * The method shows the index page
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $page = $request->get('page', '1');
        $schools = School::allWithCache(Carbon::now()->addMinutes(5), SchoolsController::PER_PAGE, $page);

        return view('dashboard.admin.schools.index', compact('schools'));
    }

    /**
     * This method stores a school
     *
     * @return RedirectResponse
     */
    public function store(SchoolsStoreRequest $request)
    {
        try {
            $school = School::create([
                'name' => $request->name,
                'email_contact' => $request->email_contact,
                'phone_number' => $request->phone_number,
                'address' => $request->address
            ]);
            Invite::create(['school_id' => $school->id, 'code' => Str::substr(Crypt::encryptString($school->name . 'teacher'), 0, 127), 'action' => 1]);

        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('schools.index')->with(['success' => __('Școala a fost creată cu succes.')]);
    }

    /**
     * This method handles the editing process of a school in the admin dashboard
     *
     * @return RedirectResponse
     */
    public function update(SchoolsStoreRequest $request, School $school)
    {
        try {
            $schoolUpdated = $school->update([
                'name' => $request->name,
                'email_contact' => $request->email_contact,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
            ]);
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('schools.index')->with(['success' => __('Școala a fost actualizată cu succes.')]);
    }

    /**
     * The page to show the user's details
     *
     * @param School $school
     * @return RedirectResponse
     */
    public function show(School $school)
    {
        return \Redirect::route('classes.index', ['school' => $school]);
    }

    /**
     * The page where the user can edit school details
     *
     * @param School $school
     * @return Application|Factory|View
     */
    public function edit(School $school)
    {
        return view('dashboard.admin.schools.edit', compact('school'));
    }

    /**
     * The page to create a new school
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('dashboard.admin.schools.new');
    }

    /**
     * The destroy method to delete the user...
     *
     * @param School $school
     * @return RedirectResponse
     */
    public function destroy(School $school)
    {
        try {
            $school->delete();
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return back()->with([
            'success' => __('Școala a fost ștearsă cu succes.')
        ]);
    }

    /**
     * This function is it used to show the deleted users view.
     *
     * @return Application|Factory|View
     */
    public function deleted()
    {
        $schools = School::onlyTrashed()->paginate(SchoolsController::DELETED_PER_PAGE);

        return view('dashboard.admin.schools.deleted', compact('schools'));
    }

    /**
     * This method is used to force delete an entity which is soft deleted...
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function forceDelete(int $id)
    {
        try {
            $school = School::withTrashed()->findOrFail($id);
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $school->forceDelete();

        return back()->with([
            'success' => __('Școala a fost eliminată definitiv.')
        ]);
    }

    /**
     * This function is used to restore a user from the soft deleted list...
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function restore(int $id)
    {
        try {
            $school = School::withTrashed()->findOrFail($id);
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $school->restore();

        return back()->with([
            'success' => __('Școala a fost restaurată cu succes.')
        ]);
    }
}
