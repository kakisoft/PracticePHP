<?php

//===========================
//   ファイルのダウンロード
//===========================

    // 存在チェック後、ある場合はダウンロード
    if( file_exists($csv_file_path) ) {

        // ファイルサイズ取得
        $excel_obj = file_get_contents($csv_file_path);
        $num_bytes = strlen($excel_obj);

        $office_name = $this->userData['office_name'];
        $new_file_name = "案件状況（" . $office_name . "）_" . date( "Ymd-His" ) . ".csv";

        // ダウンロード処理
        header("Content-Type: application/octet-stream");
        header("Content-Length: $num_bytes");
        header("Content-Disposition: attachment; filename=".mb_convert_encoding($new_file_name, 'sjis-win', 'UTF-8'));
        // header("Content-Disposition: attachment; filename=".rawurlencode($new_file_name));  // Edge タイトルの文字化け対策
        readfile($csv_file_path);
        // ダウンロード後、ファイルを削除する
        unlink($csv_file_path);
    }


// header("Content-Disposition: attachment; filename=".rawurlencode($new_file_name));

// PHPでダウンロードさせるファイル名がIEで文字化けする件
// https://qiita.com/takehironet/items/79c025e4140e29c57abe

