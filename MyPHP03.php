<?php

//==========================
//        Cookie
// 複数ページにまたがって設定できる値（クライアント（正確にはブラウザ）に値を保持）
//==========================
setcookie("username", "taguchi"); // 第三引数にて、有効期限を設定できる。設定しない場合、ブラウザを閉じるまで有効。
// setcookie("username", "taguchi", time()+60*60); // 有効期限：1時間

// setcookie("username", "taguchi", time()-60*60); // Cookieを削除する場合、適当なマイナス値を設定する。

# ＜Cookieの取得＞
# $_COOKIE という定義済みの変数があるので、それに対して 'username' というキーを与えてあげます。
echo $_COOKIE['username'];