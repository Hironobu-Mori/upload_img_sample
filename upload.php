<?php
    define('UPLOAD_DIR', __DIR__."/upload/");
    //サーバー上で保存されている画像の一時ファイル名
    $tmp_name = null;
    //htmlに返すステータスコード
    $status_code = null;

    /**
     * //アップロードされた画像ファイル拡張子の正当性を検証
     *
     * @param [binary] $tmp_name
     * @return string || false
     */
    function mine_type_validate ($tmp_name) {
        //画像ファイル拡張子の配列
        $extension_array = array(
            'gif' => 'image/gif',
            'jpg' => 'image/jpeg',
            'png' => 'image/png'
        );
        $f_info = finfo_open(FILEINFO_MIME_TYPE);
        $binary_mime_type = finfo_file(
            $f_info,
            $tmp_name
        );
        finfo_close($f_info);
        return array_search($binary_mime_type, $extension_array, true);
    }

    /**
     * 画像ファイルをリサイズ(デフォルトは500x500)
     *
     * @param [type] $tmp_name
     * @param [type] $ext
     * @param integer $resize_width
     * @param integer $resize_height
     * @return void
     */
    function resize_image($tmp_name, $ext, $resize_width=500, $resize_height=500) {
        //uploadフォルダに入れる際のファイル名
        $new_file_name = 'new'.$ext;
        list($width, $height) = getimagesize($tmp_name); // 元の画像名を指定してサイズを取得
        $image = imagecreatetruecolor($resize_width, $resize_height); // サイズを指定して新しい画像のキャンバスを作成
        
        if ($ext == 'jpg') {
            // コピーした画像を出力する
            $baseImage = imagecreatefromjpeg($tmp_name);
            // 画像のコピーと伸縮
            imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $resize_width, $resize_height, $width, $height);
            return imagejpeg($image , UPLOAD_DIR.$new_file_name);
        }

        if ($ext == 'png') {
            // コピーした画像を出力する
            $baseImage = imagecreatefrompng($tmp_name);
            //ブレンドモードを無効にする
            imagealphablending($image, false);
            //完全なアルファチャネル情報を保存するフラグをonにする
            imagesavealpha($image, true);
            // 画像のコピーと伸縮
            imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $resize_width, $resize_height, $width, $height);
            return imagepng($image , UPLOAD_DIR.$new_file_name);
        }

        if ($ext == 'gif') {
            // コピーした画像を出力する
            $baseImage = imagecreatefromgif($tmp_name);
            //ブレンドモードを無効にする
            imagealphablending($image, false);
            //完全なアルファチャネル情報を保存するフラグをonにする
            imagesavealpha($image, true);
            // 画像のコピーと伸縮
            imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $resize_width, $resize_height, $width, $height);
            return imagegif($image , UPLOAD_DIR.$new_file_name);
        }
        return false;
    }


    //index.phpからPOSTでアップロードされているか判定
    if (empty($_POST['uploaded']) || empty($_FILES['upfile'])) {
        header('Location: index.php?code=4');
        exit;
    }

    //ファイルアップロードが正常でない場合エラーコードをクエリパラメータで返す
    if (!$_FILES['upfile']['error'] == UPLOAD_ERR_OK) {
        $status_code = $_FILES['file']["error"];
        header('Location: index.php?code='.$status_code);
        exit;
    }

    //
    $tmp_name = $_FILES['upfile']['tmp_name'];
    if ($ext = !mine_type_validate($tmp_name)) {
        header('Location: index.php?code=9');
        exit;
    }

    //画像のリサイズ処理
    if(!resize_image($tmp_name, $ext)) {
        header('Location: index.php?code=4');
        exit;
    }











