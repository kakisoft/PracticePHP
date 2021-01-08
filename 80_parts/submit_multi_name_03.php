<?php
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━
＜ビルトインサーバ起動＞

php -S localhost:8001

終了は、「Ctrl + C」
------------------------------

http://localhost:8001/submit_multi_name_03.php

━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

// NULL
// array(2) { [0]=> string(1) "3" [1]=> string(1) "6" }
// array(6) { [0]=> string(1) "1" [1]=> string(1) "2" [2]=> string(1) "3" [3]=> string(1) "4" [4]=> string(1) "5" [5]=> string(1) "6" }

$boxList = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  var_dump($_POST['boxlist']);

  if (!is_null($_POST['boxlist'])) {
    $boxList = $_POST['boxlist'];
  }
}



?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>submit_multi_name_03</title>
  <h1>submit_multi_name_03</h1>
</head>
<body>
  <form action="submit_multi_name_03.php" method="POST">
    <div>
      <input type="text" name="username" placeholder="user name" value="">
    </div>
    <div>
      <?php for($i=0; $i<5; $i++){ ?>
        <input type="checkbox" name=boxlist[] value="<?php echo $i ?>" <?php if(in_array($i, $boxList))  echo "checked" ?> ><?php echo $i ?>
      <?php } ?>
    </div>
    <div>
      <input type="submit" value="submit!!">
    </div>
  </form>
</body>
</html>