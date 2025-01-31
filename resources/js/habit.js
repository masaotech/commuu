// =========================================================================================================
// 定期To-Do （編集）画面
// =========================================================================================================
// 周期の単位が変更された際
let elements = document.getElementsByName('cycle_type');
elements.forEach(element => {
    element.addEventListener('change', function () {
        set_cycle_type_area();
    });
});

function set_cycle_type_area() {
    // 選択された周期の取得
    let cycle_type_elements = document.getElementsByName('cycle_type');
    let selected_cycle_type;
    cycle_type_elements.forEach(e => {
        if (e.checked == true) {
            selected_cycle_type = e.value;
        }
    })

    // 要素の取得(表示エリア)
    monthly_block = document.getElementById('monthly_block');
    weekly_block = document.getElementById('weekly_block');
    daily_block = document.getElementById('daily_block');

    // 要素の取得(フォーム要素)
    monthly_cycle = document.getElementById('monthly_cycle');
    monthly_day = document.getElementById('monthly_day');
    weekly_days = document.getElementsByName('weekly_days[]');
    weekly_cycle = document.getElementById('weekly_cycle');
    daily_cycle = document.getElementById('daily_cycle');
    daily_day = document.getElementById('daily_day');

    // 選択された周期タイプ毎の処理
    if (selected_cycle_type == 'monthly') {
        // 表示非表示の設定
        monthly_block.classList.remove('hidden');
        weekly_block.classList.add('hidden');
        daily_block.classList.add('hidden');
        // required, disabled の設定
        monthly_cycle.required = true;
        monthly_cycle.disabled = false;
        monthly_day.required = true;
        monthly_day.disabled = false;

        weekly_cycle.required = false;
        weekly_cycle.disabled = true;
        weekly_days.forEach(e => {
            e.required = false;
            e.disabled = true;
        })

        daily_cycle.required = false;
        daily_cycle.disabled = true;
        daily_day.required = false;
        daily_day.disabled = true;
    } else if (selected_cycle_type == 'weekly') {
        // 表示非表示の設定
        monthly_block.classList.add('hidden');
        weekly_block.classList.remove('hidden');
        daily_block.classList.add('hidden');
        // required の設定
        monthly_cycle.required = false;
        monthly_cycle.disabled = true;
        monthly_day.required = false;
        monthly_day.disabled = true;

        weekly_cycle.required = true;
        weekly_cycle.disabled = false;
        weekly_days.forEach(e => {
            e.required = true;
            e.disabled = false;
        })

        daily_cycle.required = false;
        daily_cycle.disabled = true;
        daily_day.required = false;
        daily_day.disabled = true;
    } else if (selected_cycle_type == 'daily') {
        // 表示非表示の設定
        monthly_block.classList.add('hidden');
        weekly_block.classList.add('hidden');
        daily_block.classList.remove('hidden');
        // required の設定
        monthly_cycle.required = false;
        monthly_cycle.disabled = true;
        monthly_day.required = false;
        monthly_day.disabled = true;

        weekly_cycle.required = false;
        weekly_cycle.disabled = true;
        weekly_days.forEach(e => {
            e.required = false;
            e.disabled = true;
        })

        daily_cycle.required = true;
        daily_cycle.disabled = false;
        daily_day.required = true;
        daily_day.disabled = false;
    }
}


// 週単位が曜日 CheckBox が変更された際
let weekly_days = document.getElementsByName('weekly_days[]');
const errorMessage = "1つ以上の選択肢を選択してください。";
weekly_days.forEach(element => {
    element.setCustomValidity(errorMessage);
    element.addEventListener('change', function () {
        set_weekly_days_required();
    });
});
function set_weekly_days_required() {
    const isCheckedAtLeastOne = document.querySelector(".weekly_days:checked") !== null;

    // 1つもチェックがされていなかったら、すべてのチェックボックスを required にする
    // 加えて、エラーメッセージも変更する
    weekly_days.forEach(element => {
        element.required = !isCheckedAtLeastOne
        element.setCustomValidity(isCheckedAtLeastOne ? "" : errorMessage);
    });
}

