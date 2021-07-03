## 【Laravel】Laravel6からstr_randomとarr_randomヘルパが使えない
https://qiita.com/mako0104/items/f603494b64d97111f591
```php
// Laravel6から使用不可
str_random(10))

/*
これで使えるようになる
composer require laravel/helpers
*/

// こう変わった
Str::random(10)
```
https://readouble.com/laravel/7.x/ja/seeding.html





```
Hash::make
Str::random()
Arr::random($array, 要素数);
```


```php
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
```