https://www.php.net/manual/ja/dir.constants.php
```
定義済み定数
DIRECTORY_SEPARATOR (string)
PATH_SEPARATOR (string)
Windows の場合はセミコロン、それ以外の場合はコロンとなります。
SCANDIR_SORT_ASCENDING (integer)
PHP 5.4.0 以降で使用可能です。
SCANDIR_SORT_DESCENDING (integer)
PHP 5.4.0 以降で使用可能です。
SCANDIR_SORT_NONE (integer)
PHP 5.4.0 以降で使用可能です。
```


## index.php
```php
define( 'DOCUMENT_ROOT_REALPATH', realpath(dirname(__FILE__)) );               // ルートの実体パス
```


________________________________________________________________________
## _
```php

//==========================
//      メモリチェック
//==========================
// memory_get_usage
// PHP に割り当てられたメモリの量を返す
// 現在の PHP スクリプトに割り当てられたメモリの量をバイト単位で返します。

echo memory_get_usage() . "\n"; // 393120(数字は適当。場合によって変わる)

$a = str_repeat("Hello", 4242);

echo memory_get_usage() . "\n"; // 417728(数字は適当。場合によって変わる)


//---------------
//
//---------------
echo "before:".memory_get_usage() / (1024 * 1024)."MB\n";  //=> before:0.40116882324219MB

$arr = [];
for($i=0;$i<10000;$i++) {
    $arr[] = $i;
}

echo "after:".memory_get_usage() / (1024 * 1024)."MB\n"; //=> after:0.90512847900391MB


//---------------
//  最大使用量
//---------------
// memory_get_peak_usage
// phpに割り当てられたメモリ使用量の最大値を取得
echo "before:".memory_get_usage() / (1024 * 1024)."MB\n";  //=> before:0.90512847900391MB

$arr = [];
for($i=0;$i<10000;$i++) {
    $arr[] = $i;
}

//半分開放する
for($i=0;$i<5000;$i++) {
    unset($arr[$i]);
}

echo "after:".memory_get_usage() / (1024 * 1024)."MB\n";        //=> after:0.90512847900391MB
echo "peak:".memory_get_peak_usage() / (1024 * 1024)."MB\n";    //=> peak:0.90541839599609MB
```

________________________________________________________________________
## __
```php
    public function testlibxlAction(){
        set_time_limit(0);
        ini_set('memory_limit', '2G');

        // LIB XLで試すバージョン
        $this->_helper->viewRenderer->setNoRender();

$time_start = microtime(true);
$memory_start = memory_get_usage();
// logout2("LIBXL-START " , $this->debug($time_start, $memory_start));

        // 準備部
        set_include_path(get_include_path() . PATH_SEPARATOR . DOCUMENT_ROOT_REALPATH . '/library/php_excel/docs');

        // 実処理部
        $objExcel = new ExcelBook(null, null, true);
        $objSheet = $objExcel->addSheet('test');


        // セルに値を入れる
        for ($row = 1; $row <= 10; $row++) {
            for ($col = 0; $col < 10; $col++) {
                $objSheet->write($row - 1, $col, 'あいJISてすと感じ', null, ExcelFormat::AS_NUMERIC_STRING);
            }
        }


        header('Content-Type: application/octet-stream');
        header('Content-Disposition:attachment;filename="test.xlsx"');
        $objExcel->save('php://output');

// logout2("LIBXL-END ", $this->debug($time_start, $memory_start));
    }
``` 



