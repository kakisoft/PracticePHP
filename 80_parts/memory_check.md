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



