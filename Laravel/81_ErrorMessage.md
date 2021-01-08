## エラー
https://readouble.com/laravel/5.5/ja/validation.html#working-with-error-messages
指定フィールドの最初のエラーメッセージ取得
```php
echo $errors->first('email');
```
指定フィールドの全エラーメッセージ取得
```php
foreach ($errors->get('email') as $message) {
    //
}
```
全フィールドの全エラーメッセージ取得
```php
foreach ($errors->all() as $message) {
    //
}
```


## カスタムエラーメッセージ
Validator::make
```php
$messages = [
    'required' => 'The :attribute field is required.',
];

$validator = Validator::make($input, $rules, $messages);
```



