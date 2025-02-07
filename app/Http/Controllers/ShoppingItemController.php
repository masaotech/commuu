<?php

namespace App\Http\Controllers;

use App\Consts\ShoppingItemStatusConst;
use App\Consts\ShoppingItemCategoriesConst;
use App\Common\MassageUtil;
use App\Models\ShoppingItem;
use App\Models\User;
use App\Http\Requests\ShoppingItem\StoreRequest;
use App\Http\Requests\ShoppingItem\ChangeItemStatusRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class ShoppingItemController extends Controller
{
    /**
     * [GET] 買い物リスト一覧画面表示
     */
    public function index()
    {
        // 買い物リスト 情報取得
        $items = ShoppingItem::where('group_id', '=', $this->commonBag['userCurrentGroupId'])
            ->orderBy('item_category_id')
            ->orderBy('id')
            ->get();

        $this->addToBag('items', $items);
        return view('shoppingitem/index', $this->commonBag);
    }

    /**
     * [GET] 買い物リスト(編集) 画面表示
     */
    public function edit()
    {
        // 買い物リスト 情報取得
        $items = ShoppingItem::where('group_id', '=', $this->commonBag['userCurrentGroupId'])
            ->orderBy('item_category_id')
            ->orderBy('id')
            ->get();

        $this->addToBag('items', $items);
        return view('shoppingitem/edit', $this->commonBag);
    }

    /**
     * [POST] アイテム新規登録処理
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $newItem = new ShoppingItem();
        $newItem->group_id = $this->commonBag['userCurrentGroupId'];
        $newItem->name = $request->name;
        $newItem->item_category_id = $request->item_category_id;
        $newItem->item_status_code_id = ShoppingItemStatusConst::PURCHASING_TARGET;
        $newItem->save();

        return Redirect::route('shoppingitem.index')->with('flash-message-info', '「' . $request->name . '」を購入対象に追加しました');
    }

    /**
     * [POST] アイテムのステータス変更(API)
     */
    public function changeItemStatus(Request $request)
    {
        try {
            // リクエストデータをJSON変換
            $content = $request->getContent();
            $json = json_decode($content, true) ?? [];

            // バリデーション
            $this->validCurrentGroup($json['user_current_group_id']);
            $this->validItemStatusCode($json['item_status_code']);
            $this->validItemId($json['item_id']);

            // 更新対象アイテム取得
            $item = ShoppingItem::where('group_id', '=', $this->commonBag['userCurrentGroupId'])
                ->where('id', '=', $json['item_id'])->get()->first();

            // ステータスコード更新
            $item->item_status_code_id = $json['item_status_code'];
            $item->save();

            // フラッシュメッセージセット
            if ($json['item_status_code'] == ShoppingItemStatusConst::PURCHASING_TARGET) {
                $message = '「' . $item->name . '」を購入対象にしました';
            } else if ($json['item_status_code'] == ShoppingItemStatusConst::PURCHASED) {
                $message = '「' . $item->name . '」を購入済にしました';
            }

            $responseData = [
                'result' => 'OK',
                'html_data' => MassageUtil::flashMassageInfo(htmlspecialchars($message))
            ];
        } catch (\Exception $e) {
            $responseData = [
                'result' => 'NG',
                'html_data' => MassageUtil::flashMassageError(htmlspecialchars('更新に失敗しました(' . $e->getMessage() . ')')),
            ];
        }
        return response()->json($responseData);
    }

    /**
     * [POST] アイテムの情報更新(API)
     */
    public function updateItemInfo(Request $request)
    {
        try {
            // リクエストデータをJSON変換
            $content = $request->getContent();
            $json = json_decode($content, true) ?? [];

            // バリデーション
            $this->validCurrentGroup($json['user_current_group_id']);
            $this->validItemCategoryId($json['item_category_id']);
            $this->validItemId($json['item_id']);
            $this->validItemNamw($json['item_name']);

            // 更新対象アイテム取得
            $item = ShoppingItem::where('group_id', '=', $this->commonBag['userCurrentGroupId'])
                ->where('id', '=', $json['item_id'])->get()->first();

            // 更新
            $item->name = $json['item_name'];
            $item->item_category_id = $json['item_category_id'];
            $item->save();

            $responseData = [
                'result' => 'OK',
                'html_data' => MassageUtil::flashMassageInfo(htmlspecialchars('「' . $item->name . '」の設定を更新しました')),
            ];
        } catch (\Exception $e) {
            $responseData = [
                'result' => 'NG',
                'html_data' => MassageUtil::flashMassageError(htmlspecialchars('更新に失敗しました(' . $e->getMessage() . ')')),
            ];
        }
        return response()->json($responseData);
    }

    /**
     * [POST] アイテムの削除(API)
     */
    public function deleteItemInfo(Request $request)
    {
        try {
            // リクエストデータをJSON変換
            $content = $request->getContent();
            $json = json_decode($content, true) ?? [];

            // バリデーション
            $this->validCurrentGroup($json['user_current_group_id']);
            $this->validItemId($json['item_id']);

            // 削除対象アイテム取得
            $item = ShoppingItem::where('group_id', '=', $this->commonBag['userCurrentGroupId'])
                ->where('id', '=', $json['item_id'])->get()->first();

            // 削除
            $item->delete();

            $responseData = [
                'result' => 'OK',
                'html_data' => MassageUtil::flashMassageInfo(htmlspecialchars('「' . $item->name . '」を削除しました')),
            ];
        } catch (\Exception $e) {
            $responseData = [
                'result' => 'NG',
                'html_data' => MassageUtil::flashMassageError(htmlspecialchars('削除が失敗しました')),
            ];
        }
        return response()->json($responseData);
    }

    /**
     * [private] 【バリデーション】ポストされた現在のグループIDと、DBの現在のグループが一致する事の確認
     */
    private function validCurrentGroup($postedCurrentGroupId)
    {
        $registered = User::where('id', '=', Auth::user()->id)->get()->first();
        if ($registered->current_group_id != $postedCurrentGroupId) {
            throw new \Exception('別画面でグループが「' . $registered->currentGroup->name . '」に変更されています。画面リロードしてください');
        }
    }

    /**
     * [private] 【バリデーション】ポストされたステータスコードが適切か確認
     */
    private function validItemStatusCode($postedItemStatusCode)
    {
        $targetArray = [
            ShoppingItemStatusConst::PURCHASED,
            ShoppingItemStatusConst::PURCHASING_TARGET
        ];

        if (array_search($postedItemStatusCode, $targetArray) === false) {
            throw new \Exception('不正な状態コードが指定されました');
        }
    }

    /**
     * [private] 【バリデーション】ポストされたカテゴリIDが適切か確認
     */
    private function validItemCategoryId($postedItemCategoryId)
    {
        $targetArray = [
            ShoppingItemCategoriesConst::COLOR_1_ID,
            ShoppingItemCategoriesConst::COLOR_2_ID,
            ShoppingItemCategoriesConst::COLOR_3_ID,
            ShoppingItemCategoriesConst::COLOR_4_ID,
            ShoppingItemCategoriesConst::COLOR_5_ID,
        ];

        if (array_search($postedItemCategoryId, $targetArray) === false) {
            throw new \Exception('不正なカテゴリが指定されました');
        }
    }

    /**
     * [private] 【バリデーション】ポストされたアイテムIDが適切か確認
     */
    private function validItemId($postedItemId)
    {
        $item = ShoppingItem::where('group_id', '=', $this->commonBag['userCurrentGroupId'])
            ->where('id', '=', $postedItemId)->get()->first();
        if ($item == null) {
            throw new \Exception(message: '不正なアイテムが選択されました');
        }
    }

    /**
     * [private] 【バリデーション】ポストされたアイテム名が適切か確認
     */
    private function validItemNamw($postedItemName)
    {
        if (mb_strlen($postedItemName) >= 256) {
            throw new \Exception(message: '商品名は255文字以下で入力してください');
        }
    }
}
