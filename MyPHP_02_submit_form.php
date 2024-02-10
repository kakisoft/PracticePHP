<?php
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━
＜ビルトインサーバ起動＞

php -S localhost:8001

終了は、「Ctrl + C」
------------------------------

http://localhost:8001/MyPHP_02_submit_form.php

━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // var_dump($_POST['boxlist']);
  var_dump($_REQUEST);
  // print_r($_REQUEST);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>MyPHP_02_submit_form.php</title>
  <h1>MyPHP_02_submit_form.php</h1>
</head>
<body>
  <!-- <form action="submit_multi_name_01.php" method="POST"> -->
  <form method="POST">
    <h3>テキストボックス （ name="username" ）</h3>
    <div>
      <input type="text" name="username" placeholder="user name" value="">
    </div>

    <h3>チェックボック （ name="boxlist[]" ）</h3>
    <div>
      <input type="checkbox" name=boxlist[] value="1"        >1
      <input type="checkbox" name=boxlist[] value="2" checked>2
      <input type="checkbox" name=boxlist[] value="3" checked>3
      <input type="checkbox" name=boxlist[] value="4"        >4
      <input type="checkbox" name=boxlist[] value="5"        >5
      <input type="checkbox" name=boxlist[] value="6" checked>6
    </div>

    <h3>ラジオボタン （ name="color" ）</h3>
    <div>
      <input type="radio" name="color" value="Red" checked>Red
      <input type="radio" name="color" value="Blue">Blue
    </div>

    <h3>セレクトメニュー （ name="city" ）</h3>
    <div>
      <select name="city">
        <option value="Tokyo">Tokyo</option>
        <option value="Nagoya">Nagoya</option>
        <option value="Osaka">Osaka</option>
        <option value="Kyoto">Kyoto</option>
        <option value="Fukuoka" selected>Fukuoka</option>
      </select>
    </div>

    <br><br>
    <div>
      <input type="submit" value="submit!!">
    </div>
  </form>
</body>
</html>