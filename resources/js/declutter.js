// =========================================================================================================
// 断捨離アイテム画面
// =========================================================================================================

// ファイル選択（画像選択）画面の表示
document.getElementById('file_choice_btn').addEventListener("click", () => {
    document.getElementById("input_file").click();
});

// input に指定された画像の表示
const input = document.querySelector('#input_file')
const figure = document.querySelector('#figure')
const figureImage = document.querySelector('#figureImage')

input.addEventListener('change', (event) => { // <1>
    const [file] = event.target.files

    if (file) {
        figureImage.setAttribute('src', URL.createObjectURL(file))
        figure.style.display = 'block'
    } else {
        figure.style.display = 'none'
    }
})

// ドロップダウンリストから日付指定時
document.getElementById('date_options').addEventListener("change", (e) => {
    // 値セット
    document.getElementById("target_day").value = e.target.value;
});
