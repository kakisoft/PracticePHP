<?php

$username = '';
#  $_SERVER という定義済みの変数の中の、REQUEST_METHOD というものがある。
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  # $_POST で名前を渡してあげると、POST された内容を取得することができます。
  $username = $_POST['username'];
  $err = false;
  if (strlen($username) > 8) {
    $err = true;
  }
}


// ## GET/POST の識別
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // POST：フォームからの投稿などのとき
// } else {
//     // GET：リンクのクリックによる表示のリクエストなどのとき
// }


// PECL   
//
// $_REQUEST は現在の $_GET、$_POST、$_COOKIE などの内容をまとめた変数  


# ↓は、「form action=""」となっているので、submitしたら、このページに遷移する。
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Check username</title>
</head>
<body>
  <form action="" method="POST">
    <input type="text" name="username" placeholder="user name" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="submit" value="Check!">
    <?php if ($err) { echo "Too long!"; } ?>
  </form>
</body>
</html>


