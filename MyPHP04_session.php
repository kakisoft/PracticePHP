<?php

//==========================
//        session
// 複数ページにまたがって設定できる値（サーバ側に保持）
//==========================

session_start(); //セッション開始

$_SESSION['username'] = "sawai";

echo $_SESSION['username'];

// unset($_SESSION['username']); //セッション終了


// session_destroy


// 現在のセッション ID を取得または設定する
$a1 = session_id();  //=> odqq13fskp08jlaj83gr2bafh5

