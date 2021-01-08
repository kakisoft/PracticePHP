<?php

//=================================
//      プロセスの多重起動を防止
//=================================

$fp = fopen("sample01.txt", "r+");

if (flock($fp, LOCK_EX)) {  // 排他ロックを確保します
    ftruncate($fp, 0);      // ファイルを切り詰めます  // ftruncate — ファイルを指定した長さに丸める
    fwrite($fp, "ここで何かを書きます\n");
    fflush($fp);            // 出力をフラッシュしてからロックを解放します
    flock($fp, LOCK_UN);    // ロックを解放します

    echo "ファイルを取得できました。";
} else {
    echo "ファイルを取得できません!";
}

fclose($fp);




// プロセスの多重起動をアドバイザリロックで防止する for PHP
// https://qiita.com/ngyuki/items/5cb004dba45b0adaa9f7



