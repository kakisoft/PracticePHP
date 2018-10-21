<?php
// require "./Team.class.php";
require "./MyPagerClass.php";

const DEFAULT_NUMBER_OF_BOX = 5;
const DEFAULT_DISP_RECORD_COUNT = 20;

const DEFAULT_CURRENT_PAGE = 1;
const DEFAULT_ALL_RECORD_COUNT = 20;

$currentPage     = "";
$allRecordCount  = "";
$dispRecordCount = "";
$numberOfBox     = "";

if(isset($_GET['current_page']))       $currentPage     = htmlspecialchars($_GET['current_page']     , ENT_QUOTES, 'UTF-8');
if(isset($_GET['all_record_count']))   $allRecordCount  = htmlspecialchars($_GET['all_record_count'] , ENT_QUOTES, 'UTF-8');
if(isset($_GET['disp_record_count']))  $dispRecordCount = htmlspecialchars($_GET['disp_record_count'], ENT_QUOTES, 'UTF-8');
if(isset($_GET['number_of_box']))      $numberOfBox     = htmlspecialchars($_GET['number_of_box']    , ENT_QUOTES, 'UTF-8');

if(!is_numeric($currentPage))     $currentPage     = DEFAULT_CURRENT_PAGE;
if(!is_numeric($allRecordCount))  $allRecordCount  = DEFAULT_ALL_RECORD_COUNT;
if(!is_numeric($dispRecordCount)) $dispRecordCount = DEFAULT_DISP_RECORD_COUNT;
if(!is_numeric($numberOfBox))     $numberOfBox     = DEFAULT_NUMBER_OF_BOX;

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

    <form action="" method="GET">
        <hr>
        <div>
            <div><label>【現在のページ】                    <input type="number" name="current_page"      value="<?php echo $currentPage; ?>">        </label></div>
            <div><label>【トータルのレコード数】             <input type="number" name="all_record_count"  value="<?php echo $allRecordCount; ?>">        </label></div>
            <div><label>【1ページに表示するレコードの件数】   <input type="number" name="disp_record_count" value="<?php echo $dispRecordCount; ?>">        </label></div>
            <div><label>【画面上に表示する、選択可能ページ数】<input type="number" name="number_of_box"     value="<?php echo $numberOfBox; ?>">        </label></div>

            <br>
            <br>
            <input type="submit" value="Parameter Set">
        </div>
        <br><br>
        <div>
            <?php
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
            ?>
        </div>
    </form>

    <br><br>
    <?= $a1 ?>
</body>
</html>



