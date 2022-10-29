<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersStoreRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public const PER_PAGE = 5;
    public const DELETED_PER_PAGE = 10;

    public function __construct()
    {
        // TODO: Figure out permissions
//        $this->middleware('can:manage-users');
    }

    /**
     * Index method to show all the data for users.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $page = $request->get('page', '1');

        $users = User::allWithCache(Carbon::now()->addMinutes(5), UsersController::PER_PAGE, $page);
        $roles = Role::allWithCache();

        return view('dashboard.admin.users.index', compact('users', 'roles'));
    }

    /**
     * Store method to store the entry data for the user's creation in the database.
     *
     * @param UsersStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UsersStoreRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password)
            ]);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with(['success' => __('Utilizatorul a fost creat cu succes.')]);
    }

    /**
     * Store method to store the entry data for the user's creation in the database.
     *
     * @param UsersStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UsersStoreRequest $request, User $user)
    {
        try {
            $updateParams = [
                'name' => $request->name,
                'email' => $request->email
            ];
            if (isset($request->password)) {
                $updateParams['password'] = \Hash::make($request->password);
            }
            $user->update($updateParams);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with(['success' => __('Utilizatorul a fost actualizat cu succes.')]);
    }

    /**
     * The page to show the user's details
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $roles = Role::allWithCache();
        return view('dashboard.admin.users.show', compact('user', 'roles'));
    }

    /**
     * The page where the user can edit user details
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::allWithCache();
        return view('dashboard.admin.users.edit', compact('user', 'roles'));
    }

    /**
     * The page to create a new user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::allWithCache();
        return view('dashboard.admin.users.new', compact('roles'));
    }


    /**
     * The destroy method to delete the user...
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // TODO: Prevent deleting own account
        try {
            $user->delete();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return back()->with([
            'success' => __('Utilizatorul a fost șters cu succes.')
        ]);
    }

    /**
     * This function is it used to show the deleted users view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deleted()
    {
        $users = User::onlyTrashed()->paginate(UsersController::DELETED_PER_PAGE);

        return view('dashboard.admin.users.deleted', compact('users'));
    }

    /**
     * This method is used to force delete an entity which is soft deleted...
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(int $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $user->forceDelete();

        return back()->with([
            'success' => __('Utilizatorul a fost șters definitiv.')
        ]);
    }

    /**
     * This function is used to restore a user from the soft deleted list...
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(int $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $user->restore();

        return back()->with([
            'success' => __('Utilizatorul a fost restaurat.')
        ]);
    }
}
