## 特殊変数

```php

<?php
echo __FILE__."<br>";//実行中のファイル名
echo __DIR__."<br>";//実行中のファイルがあるフォルダ
echo __LINE__."<br>";//実行中の行番号
echo __FUNCTION__."<br>";//実行中の関数
echo __CLASS__."<br>";//実行中のクラス
echo __METHOD__."<br>";//実行注のメソッド
echo __NAMESPACE__."<br>";//現在の名前空間
echo DIRECTORY_SEPARATOR."<br>";//現在の環境のフォルダの区切り文字
echo PATH_SEPARATOR."<br>";//現在の環境のパスの区切り文字
echo PHP_VERSION."<br>";//PHPのバージョン
?>

```
<http://php.vowshe.info/tag/__function__/>



## スーパーグローバル
http://php.net/manual/ja/language.variables.superglobals.php

 * $GLOBALS
 * $_SERVER
 * $_GET
 * $_POST
 * $_FILES
 * $_COOKIE
 * $_SESSION
 * $_REQUEST
 * $_ENV



```php
<?php
$var = '変数です。';//グローバルスコープのグローバル変数
echo $var."<br/>\n";
echo $GLOBALS['var']."<br/>\n";//グローバル変数の参照を含む
?>

//------
変数です。
変数です。

```