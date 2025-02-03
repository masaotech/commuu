<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class GroupMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ログインユーザーがグループに紐づいているか確認
        $userRegisteredGroups = GroupUser::where('user_id', '=', Auth::user()->id)->get();
        if ($userRegisteredGroups->count() == 0) {
            // 0 件の場合、グループ新規登録画面へリダイレクト
            return Redirect::route('group.create')
                ->with('flash-message-error', '所属するグループがありません。新規でグループを登録してください');
        }

        // ログインユーザーの現在のグループが設定されているか確認
        $user = User::find(Auth::user()->id);
        if ($user->current_group_id == null) {
            // null の場合、グループ選択画面へリダイレクト
            return Redirect::route('group.pickOutGroup')
                ->with('flash-message-error', '表示対象のグループが設定されていません。リストから選択してください');
        }

        // ログインユーザーの現在のグループが所属グループか確認（この条件に当てはまることは無い想定）
        $isNotGroupMember = true;
        foreach ($userRegisteredGroups as $userRegisteredGroup) {
            if ($user->current_group_id === $userRegisteredGroup->group_id) {
                $isNotGroupMember = false;
            }
        }
        if ($isNotGroupMember) {
            // グループメンバーではない場合
            $user->current_group_id = null;
            $user->save();
            return Redirect::route('group.pickOutGroup')
                ->with('flash-message-error', '表示対象のグループが設定されていません。リストから選択してください');
        }

        return $next($request);
    }
}
