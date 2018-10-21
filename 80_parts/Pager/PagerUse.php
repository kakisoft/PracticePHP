<?php
// require "./Team.class.php";
require "./MyPagerClass.php";

$currentPage     = "";
$allRecordCount  = "";
$dispRecordCount = "";
$numberOfBox     = "";

if(isset($_GET['current_page']))       $currentPage     = htmlspecialchars($_GET['current_page']     , ENT_QUOTES, 'UTF-8');
if(isset($_GET['all_record_count']))   $allRecordCount  = htmlspecialchars($_GET['all_record_count'] , ENT_QUOTES, 'UTF-8');
if(isset($_GET['disp_record_count']))  $dispRecordCount = htmlspecialchars($_GET['disp_record_count'], ENT_QUOTES, 'UTF-8');
if(isset($_GET['number_of_box']))      $numberOfBox     = htmlspecialchars($_GET['number_of_box']    , ENT_QUOTES, 'UTF-8');

// $pager = MyPagerClass::getPager();
// $pager = MyPagerClass::getPager(1,2);
$pager = MyPagerClass::getPager($currentPage, $allRecordCount, $dispRecordCount, $numberOfBox);


if(isset($pager["chunk"] )){
    foreach ($pager["chunk"] as $value) {
        $dispContent = $value;
    
        if($value == $pager['current_page']){
            echo "【☆{$dispContent}】";
        }else{
            if($value == ""){
                echo "【...】";
            }else{
                echo "【{$dispContent}】";
            }
        }
    }

    echo "<br><br>";
    echo "{$pager['current_page']} / {$pager['max_page_number']}" ;
    echo "<br><br><br>";
}

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




