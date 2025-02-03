<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Models\User;
use App\Models\Group;
use App\Models\GroupUser;
use App\Consts\UserRoleConst;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();
        try {
            // 新規ユーザーのデフォルトグループの作成
            $group = new Group();
            $group->name = 'Team ' . $request->name;
            $group->save();

            // 新規ユーザーの作成
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'current_group_id' => $group->id,
                'password' => Hash::make($request->password),
            ]);

            // グループユーザー中間テーブル
            $groupUser = new GroupUser();
            $groupUser->group_id = $group->id;
            $groupUser->user_id = $user->id;
            $groupUser->user_role_id = UserRoleConst::ADMIN;
            $groupUser->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('rootUrl', absolute: false));
    }
}
