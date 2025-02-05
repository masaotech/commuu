<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\GroupUser;
use App\Consts\UserRoleConst;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        $user = User::find($request->user()->id);
        $user->name = $request->user()->name;
        $user->save();

        return Redirect::route('profile.edit')
            ->with('flash-message-success', 'アカウント情報が更新されました');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // アカウント削除前にグループ削除の確認
        // 所属するグループ（管理者権限）一覧の取得
        $userBelongGroups = GroupUser::where('user_id', '=', $user->id)
            ->where('user_role_id', '=', UserRoleConst::ADMIN)->get();
        foreach ($userBelongGroups as $userBelongGroup) {
            // 対象グループの監視者権限メンバー一覧の取得
            $groupMembers = GroupUser::where('group_id', '=', $userBelongGroup->group_id)
                ->where('user_role_id', '=', UserRoleConst::ADMIN)->get();
            if ($groupMembers->count() === 1) {
                // 1件のみの場合（削除するアカウントがそのグループの唯一の管理者であるためエラー）
                $message = '「' . $groupMembers->first()->group->name . '」　はあなたが唯一の管理者であるグループです。' .
                    'アカウント削除前にグループの削除もしくは、他メンバーに管理者権限を設定してください。';
                return Redirect::to('/profile')->with('flash-message-error', $message);
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
