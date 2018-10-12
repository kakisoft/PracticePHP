<?php
echo "redirect";


$statusCode = 302;
$targetUrl  = "http://www.example.com/";
//ブラウザをリダイレクトします
header("HTTP", true,  $statusCode);
header("Location: " . $targetUrl );
//header("Location: http://www.example.com/");

//リダイレクトする際に、これ以降のコードが実行されないことを確認してください
//exit;

echo "aa";

