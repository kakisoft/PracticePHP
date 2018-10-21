<?php
// require "./Team.class.php";
require "./MyPagerClass.php";

const DEFAULT_NUMBER_OF_BOX = 5;
const DEFAULT_DISP_RECORD_COUNT = 20;

const DEFAULT_CURRENT_PAGE = 1;
const DEFAULT_ALL_RECORD_COUNT = 100;

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
    <style>
        /* body{ background-color: skyblue; } */
        .pager ul li{ 	
            display: inline;
        }
    </style>
    </head>
<body>
    <form action="" method="GET">
        <hr>
        <div>
            <br>
            <div><label>【画面上に表示する、選択可能ページ数】<input type="number" name="number_of_box"     id="number_of_box"     value="<?php echo $numberOfBox; ?>"></label></div>
            <br>
            <hr>
            <div><label>【現在のページ】                    <input type="number" name="current_page"      id="current_page"      value="<?php echo $currentPage; ?>"></label></div>
            <br>
            <hr>
            <div><label>【トータルのレコード数】             <input type="number" name="all_record_count"  id="all_record_count"  value="<?php echo $allRecordCount; ?>"></label></div>
            <div><label>【1ページに表示するレコードの件数】   <input type="number" name="disp_record_count" id="disp_record_count" value="<?php echo $dispRecordCount; ?>"></label></div>

            <br>
            <br>
            <input type="submit" value="Parameter Set">
        </div>
        <div>
            <p id="page_calc_result">
                ---
            </p>
        </div>
        <br><br>
        <div class="pager">
            <ul> 		
        <!-- <li><a href="#">top</a></li> 	
        <li><a href="#">info</a></li> 	
        <li><a href="#">link</a></li>  -->


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
                                    // echo "<li><a href='#'>【{$dispContent}】</a></li>";

                                    echo "<li>";
                                    // echo "  <a href='?current_page=$dispContent'>";
                                    // echo "  <a href='?number_of_box={$numberOfBox}&disp_record_count={$disp_record_count}&all_record_count={$allRecordCount}&current_page={$currentPage}'>";
                                    echo "  <a href='";
                                    echo "?current_page={$value}";
                                    echo "&disp_record_count={$dispRecordCount}";
                                    echo "&all_record_count={$allRecordCount}";
                                    echo "&number_of_box={$numberOfBox}";
                                    echo "' ";
                                    echo "  >";
                                    echo "      【{$dispContent}】";
                                    echo "  </a>";
                                    echo "</li>";
                                }
                            }
                        }

                        echo "<br><br>";
                        echo "{$pager['current_page']} / {$pager['max_page_number']}" ;
                        echo "<br><br><br>";
                    }
                ?>
            </ul> 
        </div>
    </form>

    <br><br>
    <?= $a1 ?>

<script>
document.getElementById("number_of_box").addEventListener("change", showPageCalcResult)
document.getElementById("current_page").addEventListener("change", showPageCalcResult)
document.getElementById("all_record_count").addEventListener("change", showPageCalcResult)
document.getElementById("disp_record_count").addEventListener("change", showPageCalcResult)

showPageCalcResult();

function showPageCalcResult(){
    var dispResultArea = document.getElementById("page_calc_result");


    var numberOfBox = document.getElementById("number_of_box").value;
    var currentPage = document.getElementById("current_page").value;
    var allRecordCount = document.getElementById("all_record_count").value;
    var dispRecordCount = document.getElementById("disp_record_count").value;

    // $maxPageNumber = ceil($allRecordCount / $dispRecordCount);
    var pageCount;
    var dispContent;

    pageCount = Math.ceil(allRecordCount / dispRecordCount);
    dispContent = String(currentPage) + " / " + String(pageCount)

    if(currentPage > pageCount){
        dispContent += "　　　!!erro!! Current Page is OVER   "
    }

    dispResultArea.textContent = dispContent;
}
</script>  
</body>
</html>

    