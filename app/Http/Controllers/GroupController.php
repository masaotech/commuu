<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\StoreRequest;
use App\Http\Requests\Group\UpdateRequest;
use App\Http\Requests\Group\DestroyRequest;
use App\Http\Requests\Group\DestroyGroupUserRequest;
use App\Http\Requests\Group\AddUserAccountRequest;
use App\Http\Requests\Group\UpdateUserRoleRequest;
use App\Http\Requests\Group\EditRequest;
use App\Http\Requests\Group\LeaveGroupUserRequest;
use App\Http\Requests\Group\ChangeCurrentGroupRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\Group;
use App\Models\User;
use App\Models\GroupUser;
use App\Consts\UserRoleConst;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * [GET] グループ一覧画面表示
     */
    public function index()
    {
        // 所属グループ一覧取得
        $groupUsers = GroupUser::where('user_id', '=', Auth::user()->id)->get();

        $this->addToBag('groupUsers', $groupUsers);
        return view('group/index', $this->commonBag);
    }

    /**
     * [GET] グループ新規登録画面表示
     */
    public function create()
    {
        return view('group/create');
    }

    /**
     * [POST] グループ新規登録処理
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            // [insert] グループテーブル
            $group = new Group();
            $group->name = $request->name;
            $group->save();

            // [insert] グループユーザー中間テーブル
            $groupUser = new GroupUser();
            $groupUser->group_id = $group->id;
            $groupUser->user_id = Auth::user()->id;
            $groupUser->user_role_id = UserRoleConst::ADMIN;
            $groupUser->save();

            // [update] ユーザーテーブル
            $user = User::find(Auth::user()->id);
            $user->current_group_id = $group->id;
            $user->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return Redirect::route('group.create')
                ->with('flash-message-error', 'グループの登録に失敗しました');
        }

        return Redirect::route('group.edit', ['group' => $group])
            ->with('flash-message-success', 'グループ　「' . $request->name . '」　が新規登録されました');
    }

    /**
     * [GET] グループ設定画面表示
     */
    public function edit(EditRequest $request, Group $group)
    {
        // 編集対象のグループに対するユーザー権限を設定
        foreach ($this->commonBag['userRegisteredGroups'] as $registeredgroup) {
            if ($registeredgroup->group_id == $group->id) {
                $userRoleIdOfEditGroup = $registeredgroup->user_role_id;
                $this->addToBag('userRoleIdOfEditGroup', $userRoleIdOfEditGroup);
            }
        }

        $this->addToBag('group', $group);
        return view('group/edit', $this->commonBag);
    }

    /**
     * [POST(PATCH)] グループ名更新処理
     */
    public function update(UpdateRequest $request, Group $group): RedirectResponse
    {
        // 【バリデーション】hiddenのグループID と リクエストURIのグループIDが同一か確認
        if ($group->id != $request->group_id) {
            return Redirect::route('group.edit', ['group' => $group])
                ->with('flash-message-error', '不正な画面操作が行われました');
        }

        // データ更新
        $group->name = $request->name;
        $group->save();

        return Redirect::route('group.edit', ['group' => $group])
            ->with('flash-message-success', 'グループ名を　「' . $group->name . '」　に更新しました');
    }

    /**
     * [POST(DELETE)] グループ削除処理
     */
    public function destroy(DestroyRequest $request, Group $group): RedirectResponse
    {
        // 【バリデーション】hiddenのグループID と リクエストURIのグループIDが同一か確認
        if ($group->id != $request->group_id) {
            return Redirect::route('group.edit', ['group' => $group])
                ->with('flash-message-error', '不正な画面操作が行われました');
        }

        // 削除
        $group->delete();

        // Todo 削除したグループが現在のグループに設定されているグループの場合、
        //      以下メッセージが表示されずに、グループ選択画面へ遷移となるので対処検討する
        return Redirect::route('group.index')
            ->with('flash-message-success', 'グループ　「' . $request->group_name . '」　を削除しました');
    }

    /**
     * [POST] ユーザーアカウント追加処理
     */
    public function addUserAccount(AddUserAccountRequest $request, Group $group): RedirectResponse
    {
        // 【バリデーション】hiddenのグループID と リクエストURIのグループIDが同一か確認
        if ($group->id != $request->group_id) {
            return Redirect::route('group.edit', ['group' => $group])
                ->with('flash-message-error', '不正な画面操作が行われました');
        }

        // 招待されたアカウント取得
        $invitaionUser = User::where('email', '=', $request->mail)->get();

        // グループメンバーとして登録処理
        DB::beginTransaction();
        try {
            // 中間テーブルへ登録
            $groupUser = new GroupUser();
            $groupUser->group_id = $group->id;
            $groupUser->user_id = $invitaionUser->first()->id;
            $groupUser->user_role_id = $request->userRole;
            $groupUser->save();

            // Todo 今後の改修 新規ユーザーの場合 招待メール送信

            // メール送信完了したら commit
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return Redirect::route('group.edit', ['group' => $group])
                ->with('flash-message-error', 'グループへの招待が失敗しました');
        }
        return Redirect::route('group.edit', ['group' => $group])
            ->with('flash-message-success', '「' . $invitaionUser->first()->name . '」　をグループへ追加しました');
    }

    /**
     * [POST(PATCH)] ユーザーアカウント権限変更処理
     */
    public function updateUserRole(UpdateUserRoleRequest $request, Group $group): RedirectResponse
    {
        // 【バリデーション】hiddenのグループID と リクエストURIのグループIDが同一か確認
        if ($group->id != $request->group_id) {
            return Redirect::route('group.edit', ['group' => $group])
                ->with('flash-message-error', '不正な画面操作が行われました');
        }

        // DB更新
        $groupUser = GroupUser::where('group_id', '=', $request->group_id)
            ->where('user_id', '=', $request->member_id)
            ->get()->first();
        $groupUser->user_role_id = $request->userRole;
        $groupUser->save();
        return Redirect::route('group.edit', ['group' => $group])
            ->with('flash-message-success', '「' . $request->member_name . '」　の権限を　「' . UserRoleConst::USER_ROLE_LIST[$request->userRole] . '」　に更新しました');
    }

    /**
     * [POST(DELETE)] グループのメンバー削除処理
     */
    public function destroyGroupUser(DestroyGroupUserRequest $request, Group $group): RedirectResponse
    {
        // 【バリデーション】hiddenのグループID と リクエストURIのグループIDが同一か確認
        if ($group->id != $request->group_id) {
            return Redirect::route('group.edit', ['group' => $group])
                ->with('flash-message-error', '不正な画面操作が行われました');
        }

        // 対象ユーザーの取得
        $groupUser = GroupUser::where('group_id', '=', $group->id)
            ->where('user_id', '=', $request->member_id)
            ->get();

        // メンバー削除
        DB::beginTransaction();
        try {
            // グループユーザー中間 テーブル から削除
            $groupUser->first()->delete();

            // ユーザー情報取得
            $user = User::find($request->member_id);
            if ($user->current_group_id == $group->id) {
                // ユーザーテーブルの現在のグループIDが該当する場合 null に更新
                $user->current_group_id = null;
                $user->save();
            }

            DB::commit();
            $flashMessage = '「' . $request->member_name . '」　をグループ　「' . $group->name . '」　から削除しました';
        } catch (\Exception $e) {
            DB::rollback();
            $flashMessage = '「' . $request->member_name . '」　をグループ　「' . $group->name . '」　から削除できませんでした';
            return Redirect::route('group.edit')->with('flash-message-error', $flashMessage);
        }

        if ($request->member_id == Auth::user()->id) {
            // ログインユーザーと削除したユーザーが同じ場合
            return Redirect::route('group.index')->with('flash-message-success', $flashMessage);
        } else {
            // ログインユーザーと削除したユーザーが異なる場合
            return Redirect::route('group.edit', ['group' => $group])->with('flash-message-success', $flashMessage);
        }
    }

    /**
     * [POST] 現在のグループ変更 処理
     */
    public function changeCurrentGroup(ChangeCurrentGroupRequest $request): RedirectResponse
    {
        // 更新
        $user = User::find(Auth::user()->id);
        $user->current_group_id = $request->group_id;
        $user->save();

        // グループ名の取得
        foreach ($this->commonBag['userRegisteredGroups'] as $group) {
            if ($group->group_id == $request->group_id) {
                $groupName = $group->group->name;
            }
        }

        // 前の画面に戻る
        return back()->withInput()->with('flash-message-success', '「' . $groupName . '」　に切り替えました');
    }

    /**
     * [POST(DELETE)] グループから脱退する 処理
     */
    public function leaveGroup(LeaveGroupUserRequest $request, Group $group): RedirectResponse
    {
        // 【バリデーション】hiddenのグループID と リクエストURIのグループIDが同一か確認
        if ($group->id != $request->group_id) {
            return Redirect::route('group.edit', ['group' => $group])
                ->with('flash-message-error', '不正な画面操作が行われました');
        }

        // 削除対象ユーザーの取得
        $groupUser = GroupUser::where('group_id', '=', $request->group_id)
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        // メンバー削除
        DB::beginTransaction();
        try {
            // グループユーザー中間 テーブル から削除
            $groupUser->first()->delete();

            if ($this->commonBag['userCurrentGroupId'] == $request->group_id) {
                // ユーザーテーブルの現在のグループIDが該当する場合 null に更新
                $user = User::find(Auth::user()->id);
                $user->current_group_id = null;
                $user->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return Redirect::route('group.edit')
                ->with('flash-message-error', '「' . $group->name . '」　から脱退できませんでした');
        }
        return Redirect::route('group.index')
            ->with('flash-message-success', '「' . $group->name . '」　から脱退しました');
    }

    /**
     * [GET] 表示対象のグループを選択する 処理
     */
    public function pickOutGroup()
    {
        if ($this->commonBag['userCurrentGroupId']) {
            // 現在のグループが設定されている場合
            return Redirect::route('rootUrl');
        } else {
            // 現在のグループが設定されていない場合
            return view('group/pick-out-group', $this->commonBag);
        }
    }
}
