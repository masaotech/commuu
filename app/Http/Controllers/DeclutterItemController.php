<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclutterItem\StoreRequest;
use App\Http\Requests\DeclutterItem\DestroyRequest;
use App\Models\DeclutterItem;
use Illuminate\Support\Facades\Redirect;
use DateTime;

class DeclutterItemController extends Controller
{
    /**
     * [GET] 断捨離サポート画面表示
     */
    public function index()
    {
        // 断捨離アイテム 情報取得
        $items = DeclutterItem::where('group_id', '=', $this->commonBag['userCurrentGroupId'])
            ->orderBy('disposal_confirm_at')
            ->get();

        $this->addToBag('items', $items);
        return view('declutteritem/index', $this->commonBag);
    }

    /**
     * [POST] 断捨離サポート新規登録処理
     */
    public function store(StoreRequest $request)
    {
        // 画像ファイルのリサイズ
        $resizedFilePath = $this->resizeImage($request->file, 256, 256);

        // ファイルをbase64でエンコード
        $encodedBase64Str = base64_encode(file_get_contents($resizedFilePath));

        // DB 登録
        $declutterItem = new DeclutterItem();
        $declutterItem->note = $request->note;
        $declutterItem->group_id = $this->commonBag['userCurrentGroupId'];
        $declutterItem->image_base64 = $encodedBase64Str;
        $declutterItem->disposal_confirm_at = $request->target_day;
        $declutterItem->save();
        $target_day = new DateTime($request->target_day);
        return Redirect::route('declutter.index')
            ->with('flash-message-success', '断捨離 判定日　「' . $target_day->format('Y/n/j') . '」　で登録しました');
    }

    /**
     * [POST] 断捨離サポート削除処理
     */
    public function destroy(DestroyRequest $request)
    {
        // 削除対象のデータ取得
        $declutterItem = DeclutterItem::find($request->item_id);

        // 削除 実行
        $declutterItem->delete();

        return Redirect::route('declutter.index')->with('flash-message-success', '削除しました');
    }

    /**
     * [private] 画像のリサイズ
     */
    private function resizeImage($srcFilename, $dstWidth = 480, $dstHight = 480)
    {
        // EXIF 情報から元の画像を回転
        $this->rotateImageBasedOnExif($srcFilename->getPathname());

        // 正方形にトリミングする値をセット
        list($srcWidth, $srcHight) = getimagesize($srcFilename); // 元の画像名を指定してサイズを取得
        if ($srcWidth === $srcHight) {
            // 横幅 = 高さ の場合
            $srcX = 0;
            $srcY = 0;
        } else if ($srcWidth < $srcHight) {
            // 横幅 < 高さ の場合
            $srcX = 0;
            $srcY = ($srcHight - $srcWidth) / 2;    // 画像中央部を使用
            $srcHight = $srcWidth;    // 短い方に合わせる
        } else if ($srcWidth > $srcHight) {
            // 横幅 > 高さ の場合
            $srcX = ($srcWidth - $srcHight) / 2;    // 画像中央部を使用
            $srcY = 0;
            $srcWidth = $srcHight;    // 短い方に合わせる
        }

        $dstImage = imagecreatetruecolor($dstWidth, $dstHight); // サイズを指定して新しい画像のキャンバスを作成

        // 拡張子毎の設定
        $fileType = exif_imagetype($srcFilename);

        // 元の画像から新しい画像を作る準備
        switch ($fileType) {
            case IMAGETYPE_GIF:
                $srcImage = imagecreatefromgif($srcFilename);
                $dstFilename = "tempImage.gif";
                break;
            case IMAGETYPE_JPEG:
                $srcImage = imagecreatefromjpeg($srcFilename);
                $dstFilename = "tempImage.jpeg";
                break;
            case IMAGETYPE_PNG:
                $srcImage = imagecreatefrompng($srcFilename);
                $dstFilename = "tempImage.png";
                break;
            case IMAGETYPE_BMP:
                $srcImage = imagecreatefrombmp($srcFilename);
                $dstFilename = "tempImage.bmp";
                break;
            case IMAGETYPE_TIFF_II:
                break;
            case IMAGETYPE_TIFF_MM:
                break;
            default:
                break;
        }

        // 画像のコピーと伸縮
        imagecopyresampled($dstImage, $srcImage, 0, 0, $srcX, $srcY, $dstWidth, $dstHight, $srcWidth, $srcHight);

        $resizedFilePath = storage_path('tempImages/') . $dstFilename;

        // コピーした画像を出力する
        switch ($fileType) {
            case IMAGETYPE_GIF:
                imagegif($dstImage, $resizedFilePath);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($dstImage, $resizedFilePath);
                break;
            case IMAGETYPE_PNG:
                imagepng($dstImage, $resizedFilePath);
                break;
            case IMAGETYPE_BMP:
                imagebmp($dstImage, $resizedFilePath);
                break;
            case IMAGETYPE_TIFF_II:
                break;
            case IMAGETYPE_TIFF_MM:
                break;
            default:
                break;
        }

        // メモリ解放
        imagedestroy($srcImage);
        imagedestroy($dstImage);

        return $resizedFilePath;
    }

    /**
     * [private] 画像の回転
     */
    private function rotateImageBasedOnExif($imageFilePath)
    {

        // 画像のEXIF情報を取得
        $exif = @exif_read_data($imageFilePath, 'IFD0');

        // EXIF情報に向き情報が存在する場合は、画像回転
        if ($exif || isset($exif['Orientation'])) {

            // 画像タイプ取得
            $fileType = exif_imagetype($imageFilePath);

            // 画像を読み込む
            switch ($fileType) {
                case IMAGETYPE_GIF:
                    $srcImage = imagecreatefromgif($imageFilePath);
                    break;
                case IMAGETYPE_JPEG:
                    $srcImage = imagecreatefromjpeg($imageFilePath);
                    break;
                case IMAGETYPE_PNG:
                    $srcImage = imagecreatefrompng($imageFilePath);
                    break;
                case IMAGETYPE_BMP:
                    $srcImage = imagecreatefrombmp($imageFilePath);
                    break;
                case IMAGETYPE_TIFF_II:
                    break;
                case IMAGETYPE_TIFF_MM:
                    break;
                default:
                    break;
            }

            // 回転
            switch ($exif['Orientation']) {
                case 3:
                    // 180度回転
                    $srcImage = imagerotate($srcImage, 180, 0);
                    break;
                case 6:
                    // 90度時計回り
                    $srcImage = imagerotate($srcImage, -90, 0);
                    break;
                case 8:
                    // 90度反時計回り
                    $srcImage = imagerotate($srcImage, 90, 0);
                    break;
            }

            // 画像保存
            switch ($fileType) {
                case IMAGETYPE_GIF:
                    imagegif($srcImage, $imageFilePath);
                    break;
                case IMAGETYPE_JPEG:
                    imagejpeg($srcImage, $imageFilePath);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($srcImage, $imageFilePath);
                    break;
                case IMAGETYPE_BMP:
                    imagebmp($srcImage, $imageFilePath);
                    break;
                case IMAGETYPE_TIFF_II:
                    break;
                case IMAGETYPE_TIFF_MM:
                    break;
                default:
                    break;
            }

            // メモリ解放
            imagedestroy($srcImage);
        }
    }
}
