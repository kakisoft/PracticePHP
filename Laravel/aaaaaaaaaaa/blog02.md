

```php
//-----[ 文字列の置換：配列で対応内容を指定（strtr と str_replace で差が出るパターン）]-----
$targetText = "ABCDEABCDE";
// 以下、どちらも置換内容は同一。（「A→B」「B→C」）
$s3 = strtr($targetText, array('A' => 'B', 'B' => 'C'));           //strtr
$s4 = str_replace(array('A', 'B'), array('B', 'C'), $targetText);  //str_replace

echo $s3 . PHP_EOL;  //=> "BCCDEBCCDE"
echo $s4 . PHP_EOL;  //=> "CCCDECCCDE"

// ・置換１： A→B
// ・置換２： B→C
//
// strtr は、『変換前の文字列』に対してのみ置換を行っている。
// 「置換１： A→B」で "B" に置換された部分があったとしても、「置換２： B→C」の対象 B は対象外となる。
//
// str_replace は、「置換１： A→B」で "B" に変換された部分も、「置換２： B→C」の置換元の対象に含まれる。

```
