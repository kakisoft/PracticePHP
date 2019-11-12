<!--
静的ページのキャッシュって、保持が強力すぎやせんか・・・
渋々、こうやってPHPにする事で対処した。。
-->
<?php

$str = <<<HTML

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>My Boiler Plate</title>
</head>
<body>

<form name="my_form_01">
<input type="text" id="id_app01" name="name_app01" value="app01">
<button type="button" id="my-button-01">.ajax</button>
<br>
<p id="api-result01">
api-result01
</p>
<textarea id="api-result02" cols="80" rows="10"></textarea>
<br>
<span>Hello</span>
<div>Hello?</div>
<div></div>
<div></div>
</form>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
document.getElementById("my-button-01").addEventListener("click", myButton01Clicked)

function myButton01Clicked(){
    console.log("Hello ");

    var url = 'API_sample01_prov.php';

        $.ajax({
            url: url,
            // dataType: 'jsonp',
            dataType: "text",
            type: "GET",
            success: function(response) {
                console.log(response);
                $("#api-result01").html(response);
                $("#api-result02").val(response);

                // $("#api-result01").html("<div>aaaabb</div>")
                // $('body').html('<h1>こんにちは！</h1>');
                // $("#api-result01").html('<h1>こんにちは！</h1>');

                // $("#error").html("検索条件を指定してください");
                // $("#error").focus();
        }
    });
}

</script>  
</body>
</html>

HTML;

echo $str;
?>

