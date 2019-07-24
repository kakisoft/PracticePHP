## URLエンコード
URLとして使用できない文字や記号を、使用できる文字の特殊な組み合わせで表すように変換する。
```
// urlencode
$a1 = urlencode('abc_defああああ');

echo $a1;  #=> abc_def%E3%81%82%E3%81%82%E3%81%82%E3%81%82
echo "<br>";

// rawurlencode
//awurlencode関数は、インターネットに関する様々な仕様をまとめたRFC3986に沿った変換をしているため、urlencode関数よりrawurlencode関数を使ったほうが安全
$a2 = rawurlencode('abc_defああああ');

echo $a2;

// UTF-8の文字列をSJISに変換
$sjisStr = mb_convert_encoding($utf8Str, 'SJIS', 'UTF-8');
```
