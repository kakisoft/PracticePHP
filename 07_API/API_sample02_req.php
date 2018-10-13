<!DOCTYPE html>
<html lang="ja" manifest="sample.appcache">
<head>
  <meta charset="UTF-8">
  <title>My Boiler Plate</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Cache-Control" content="no-cache">
  <meta http-equiv="Expires" content="0">
</head>
<body>

<form name="my_form_01">
<input type="text" id="id_app01" name="name_app01" value="app01">
<button type="button" id="my-button-01">.ajax</button>
<br>
<div id="api-result01">
api-result01
</div>

</form>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
document.getElementById("my-button-01").addEventListener("click", myButton01Clicked)

function myButton01Clicked(){
    console.log("Hello ");

    var url = 'API_sample01_prov.php';

    $.ajax({
        url: url,
        // dataType: 'jsonp', / / 追加
        type: "GET",
        success: function(response) {
            // console.log(response);
            $("#api-result01").html(response)
        }
    });
}

</script>  
</body>
</html>