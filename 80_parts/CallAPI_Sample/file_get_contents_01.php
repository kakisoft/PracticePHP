<?php

//==========================
//    file_get_contents
//==========================
// curl http://challenge-your-limits.herokuapp.com/call/me

$target_url = "http://challenge-your-limits.herokuapp.com/call/me";

$res = file_get_contents($target_url);

var_dump($res);
// string(48) "{"message":"Almost! It's not GET. Keep trying."}"




// file_get_contents
// 空白のような特殊な文字を有する URI をオープンする場合には、 urlencode() でその URI をエンコードする必要があります。
