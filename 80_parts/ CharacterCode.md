## 文字コードの変換
```php
// メニューをUTF-8からEUC-JPへ変換
$this->view->payway = Convert::utf8ToEuc($this->view->payway);
```


```php
<?php
class Convert
{
    public static function utf8ToEuc($params)
    {
        if (is_array($params)) {
            foreach ($params as &$param) { $param = self::utf8ToEuc($param); }
        } else {
            $params = mb_convert_encoding($params, 'EUC-JP', 'UTF-8');
        }

        return $params;
    }

    public static function utf8ToSjis($params)
    {
        if (is_array($params)) {
            foreach ($params as &$param) { $param = self::utf8ToSjis($param); }
        } else {
            $params = mb_convert_encoding($params, 'SJIS-win', 'UTF-8');
        }

        return $params;
    }

    public static function eucToUtf8($params)
    {
        if (is_array($params)) {
            foreach ($params as &$param) { $param = self::eucToUtf8($param); }
        } else {
            $params = mb_convert_encoding($params, 'UTF-8', 'EUC-JP');
        }

        return $params;
    }

    public static function toSelectList($rows, $key, $value)
    {
        $list = ($rows instanceof Zend_Db_Table_Rowset) ? $rows->toArray() : $rows;

        if (is_array($list)) {
            $ret = array();
            foreach ($list as $item) { $ret[$item[$key]] = $item[$value]; }
            return $ret;
        }

        return array();
    }
}
?>
```