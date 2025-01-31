// =========================================================================================================
// 買い物リスト画面
// =========================================================================================================
// 商品のチェックボックスすべてループ
document.querySelectorAll('input[type=checkbox].target').forEach(function (element) {

    //チェックを変更すると発生するイベントを設置
    element.addEventListener('change', function (click_element) {
        if (element.checked) {
            //チェック ON に change した時の処理
            click_element.target.classList.contains('green') && click_element.target.closest('.cursor-pointer').classList.add('bg-green-100');
            click_element.target.classList.contains('orange') && click_element.target.closest('.cursor-pointer').classList.add('bg-orange-100');
            click_element.target.classList.contains('blue') && click_element.target.closest('.cursor-pointer').classList.add('bg-blue-100');
            click_element.target.classList.contains('red') && click_element.target.closest('.cursor-pointer').classList.add('bg-red-100');
            click_element.target.classList.contains('purple') && click_element.target.closest('.cursor-pointer').classList.add('bg-purple-100');
        } else {
            //チェック OFF に change した時の処理
            click_element.target.classList.contains('green') && click_element.target.closest('.cursor-pointer').classList.remove('bg-green-100');
            click_element.target.classList.contains('orange') && click_element.target.closest('.cursor-pointer').classList.remove('bg-orange-100');
            click_element.target.classList.contains('blue') && click_element.target.closest('.cursor-pointer').classList.remove('bg-blue-100');
            click_element.target.classList.contains('red') && click_element.target.closest('.cursor-pointer').classList.remove('bg-red-100');
            click_element.target.classList.contains('purple') && click_element.target.closest('.cursor-pointer').classList.remove('bg-purple-100');
        }
        let userCurrentGroupId = document.getElementById('user_current_group_id').value;

        // DB の値更新＆DOM更新
        $.ajax({
            type: 'post',
            url: '/shoppingitem/changeItemStatus',
            async: true,
            headers: {
                "Content-Type": "application/json",
                "X-HTTP-Method-Override": "POST",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',
            data: JSON.stringify({
                "item_id": click_element.target.value,
                "item_status_code": element.checked ? 1 : 0, // 0:購入済 1:購入対象
                "user_current_group_id": userCurrentGroupId,
            }),
            success: function (result) {
                // フラッシュメッセージDOM追加
                $("#message_area").append(result['html_data']);

                if (result['result'] == 'OK') {
                    // nop
                } else if (result['result'] == 'NG') {
                    // チェック状態を元に戻す
                    if (element.checked) {
                        click_element.target.closest('.cursor-pointer').classList.remove('bg-orange-200');
                    } else {
                        click_element.target.closest('.cursor-pointer').classList.add('bg-orange-200');
                    }
                }
            },
            error: function (request, status, error) {
                console.log(request)
                console.log(status)
                console.log(error)
            }
        })
    });
});

// 「購入対象のみ表示する」の切り替わり時
let element_disp_checked_only = document.getElementById('disp_checked_only');
if (element_disp_checked_only) {
    element_disp_checked_only.addEventListener('change', function (disp_checked_only) {
        if (disp_checked_only.target.checked) {
            //チェック ON に change した時の処理
            Array.from(document.getElementsByClassName('target_item')).forEach(function (item_element) {
                if (item_element.firstElementChild.checked == false) {
                    item_element.classList.add('hidden');
                }
            });
        } else {
            //チェック OFF に change した時の処理
            Array.from(document.getElementsByClassName('target_item')).forEach(function (item_element) {
                item_element.classList.remove('hidden');
            });
        }
    });
}


// =========================================================================================================
// 買い物リスト（編集）画面
// =========================================================================================================
// 更新ボタン押下時
let updateButtons = document.getElementsByClassName('update-item');
if (updateButtons) {
    Array.from(updateButtons).forEach(function (updateButton) {
        // ボタンをクリックすると発生するイベントを設置
        updateButton.addEventListener('click', function (clicked_button) {
            // POST用データ取得（Item番号）
            let result = clicked_button.target.id.match(/update_item_(?<item_id>\d*)/); // submit ボタンの id から item 番号を取得
            let postDataItemId = result.groups.item_id;

            // POST用データ取得（商品名）
            let name_id = "name_item_" + postDataItemId; // 商品名の input id をセット
            let postDataName = document.getElementById(name_id).value;

            // POST用データ取得（商品カテゴリ番号）
            let postDataCategoryId = "";
            let radio_name = "item_category_id_item_" + postDataItemId; // カテゴリ番号のラジオボタンの name をセット
            let radios = document.getElementsByName(radio_name);
            Array.from(radios).forEach(function (radio) {
                if (radio.checked == true) {
                    postDataCategoryId = radio.value;
                }
            });

            // POST用データ取得（現在のグループ番号）
            let userCurrentGroupId = document.getElementById('user_current_group_id').value;

            // DB の値更新＆DOM更新
            $.ajax({
                type: 'post',
                url: '/shoppingitem/updateItemInfo',
                async: true,
                headers: {
                    "Content-Type": "application/json",
                    "X-HTTP-Method-Override": "POST",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                data: JSON.stringify({
                    "item_id": postDataItemId,
                    "item_name": postDataName,
                    "item_category_id": postDataCategoryId,
                    "user_current_group_id": userCurrentGroupId,
                }),
                success: function (result) {
                    // フラッシュメッセージDOM追加
                    $("#message_area").append(result['html_data']);
                },
                error: function (request, status, error) {
                    console.log(request)
                    console.log(status)
                    console.log(error)
                }
            })
        });
    });
}

// 削除ボタン押下時
let deleteButtons = document.getElementsByClassName('delete-item');
if (deleteButtons) {
    Array.from(deleteButtons).forEach(function (deleteButton) {
        // ボタンをクリックすると発生するイベントを設置
        deleteButton.addEventListener('click', function (clicked_button) {
            // POST用データ取得（Item番号）
            let result = clicked_button.target.id.match(/delete_item_(?<item_id>\d*)/); // submit ボタンの id から item 番号を取得
            let postDataItemId = result.groups.item_id;
            let userCurrentGroupId = document.getElementById('user_current_group_id').value;

            // DB の値更新＆DOM更新
            $.ajax({
                type: 'post',
                url: '/shoppingitem/deleteItemInfo',
                async: true,
                headers: {
                    "Content-Type": "application/json",
                    "X-HTTP-Method-Override": "POST",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                data: JSON.stringify({
                    "item_id": postDataItemId,
                    "user_current_group_id": userCurrentGroupId,
                }),
                success: function (result) {
                    // フラッシュメッセージDOM追加
                    $("#message_area").append(result['html_data']);
                    // 非表示
                    clicked_button.target.closest('.categories').classList.add('hidden');
                    clicked_button.target.closest('.categories').previousElementSibling.classList.add('hidden');
                },
                error: function (request, status, error) {
                    console.log(request)
                    console.log(status)
                    console.log(error)
                }
            })
        });
    });
} 
