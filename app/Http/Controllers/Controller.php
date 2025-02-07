<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    // コントローラー内で共通利用する連想配列（最終的にはViewへ渡す）
    public $commonBag = [];

    public function __construct()
    {
        if (!empty(Auth::user())) {
            // 認証済の場合
            $this->setUserRegisteredGroups();
            $this->setUserCurrentGroupId();
            $this->setUserRoleIdOfCurrentGroup();
        }
    }

    /**
     * view へ渡す連想配列にデータを追加する
     * @param string $key
     * @param mixed $value
     * @return void
     */
    protected function addToBag($key, $value): void
    {
        $this->commonBag = array_merge($this->commonBag, array($key => $value));
    }

    /**
     * アカウントに紐づいたグループ一覧取得＆設定
     * @return void
     */
    private function setUserRegisteredGroups(): void
    {
        $userRegisteredGroups = GroupUser::where('user_id', '=', Auth::user()->id)->get();
        $this->addToBag('userRegisteredGroups', $userRegisteredGroups);
    }

    /**
     * アカウントの現在のグループID取得
     * @return void
     */
    private function setUserCurrentGroupId(): void
    {
        $user = User::find(Auth::user()->id);
        $userCurrentGroupId = $user->current_group_id;
        $this->addToBag('userCurrentGroupId', $userCurrentGroupId);
    }

    /**
     * アカウントの現在のグループに対するユーザー権限を取得
     * @return void
     */
    private function setUserRoleIdOfCurrentGroup(): void
    {
        foreach ($this->commonBag['userRegisteredGroups'] as $group) {
            if ($group->group_id == $this->commonBag['userCurrentGroupId']) {
                $userRoleIdOfCurrentGroup = $group->user_role_id;
                $this->addToBag('userRoleIdOfCurrentGroup', $userRoleIdOfCurrentGroup);
            }
        }
    }
}
