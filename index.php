<?php
    $phpFileUploadErrors = array(
        UPLOAD_ERR_OK => 'アップロードに成功しました',
        UPLOAD_ERR_INI_SIZE => ' アップロードされたファイルは、php.ini の upload_max_filesize ディレクティブの値を超えています。',
        UPLOAD_ERR_FORM_SIZE => 'アップロードされたファイルは、HTML フォームで指定された MAX_FILE_SIZE を超えています。',
        UPLOAD_ERR_PARTIAL => 'アップロードされたファイルは一部のみしかアップロードされていません。',
        UPLOAD_ERR_NO_FILE => 'ファイルはアップロードされませんでした。',
        UPLOAD_ERR_NO_TMP_DIR => 'テンポラリフォルダがありません。',
        UPLOAD_ERR_CANT_WRITE => 'ディスクへの書き込みに失敗しました',
        UPLOAD_ERR_EXTENSION => 'PHP の拡張モジュールがファイルのアップロードを中止しました。',
    );
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像アップロードサンプル</title>
    <style>
        .success {
            color: lightgreen
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <?php 
        //アップロードエラー時は
        if (isset($_GET['code']) && !empty($phpFileUploadErrors[$_GET['code']])): 
    ?>
        <h4 class="<?= $_GET['code'] == 0? 'success': 'error' ?>">
            <?= $_GET['code'] == 0? '成功': 'エラー' ?>: <?= $phpFileUploadErrors[$_GET['code']] ?>
        </h4>
    <?php endif ?>
    <form action="./upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="upfile">
        <input type="submit" name="uploaded">
    </form>
</body>
</html>