<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UsersStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // @todo when done with permissions update this...
        $user->can('manage-users');
        return view('dashboard.admin.users.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
      public function store(UsersStoreRequest $request) {
        try {
            $user = User::create($request->only(['name', 'email', 'password']));
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        $user->assignRole($request->role);

        return back()->with([
                'success' => __('The user has been created with success, congrats.'),
                'user' => $user
            ]);
    }

    public function rules()
    {
        return [
            'name' => ['required', 'alpha_space', 'string', 'between:7,32'],
            'email' => ['required', 'email', 'unique:users,email', 'between:8,64'],
            'password' => ['required', 'string', 'between:6,32', 'confirmed'],
            'role' => ['required', 'string', 'exists:roles,name'],
        ];
    }
}
