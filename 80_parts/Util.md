## 全角trim
```php
public static function mb_trim($str) {
    $str = preg_replace('#^[ 　]+#u', '', $str);
    $str = preg_replace('#[ 　]+$#u', '', $str);
    return $str;
}
``
`