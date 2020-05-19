<?php


## JSON エンコードした時に「/」が「\/」になる挙動を回避
<?php


// 通常、json_encode した場合、「/」は「\/」にエスケープされます。
$array_data = [
    'message' => 'Please register as /regist_users',
];


echo json_encode($array_data);
//=> {"message":"Please register as \/regist_users"}


// エスケープさせず、そのまま「/」を表示したい場合、JSON_UNESCAPED_SLASHES オプションを使います。
$array_data = [
    'message' => 'Please register as /regist_users',
];


echo json_encode($array_data, JSON_UNESCAPED_SLASHES);
//=> {"message":"Please register as /regist_users"}

＜参考＞  
https://www.php.net/manual/ja/function.json-encode.php
https://www.php.net/manual/ja/json.constants.php




