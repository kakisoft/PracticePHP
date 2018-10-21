<?php
// require "./Team.class.php";
require "./MyPagerClass.php";


$pager = MyPagerClass::getPager();



foreach ($pager["chunk"] as $value) {
    // echo "【" . $value . ";
    echo "【{$value}】";
}


echo "<br><br><br>";
// var_dump($pager);


$a1 = "aaaaaaaaaa"; 

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>My Pager01</title>
</head>
<body>

    <br><br>
    <?= $a1 ?>

    <!-- <ul>
        <li>白くま</li>
        <li>ライオン</li>
        <li>クロヒョウ</li>
        <li>チンパンジー</li>
        <li>山猫</li>
    </ul> -->

</body>
</html>




