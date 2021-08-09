## seed

#### 公式
https://readouble.com/laravel/5.5/ja/seeding.html  


#### 参考
https://www.ritolab.com/entry/27  


## コマンド
database\seeds\  
にファイルが作成される。
```
php artisan make:seeder UsersTableSeeder
```

## シーダの実行
```
composer dump-autoload


php artisan db:seed --class=UsersTableSeeder
```

## 全てのシーダを実行
```
php artisan db:seed
```
database\seeds\DatabaseSeeder.php  
を編集する。
```php
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(Question01RegistrationInformationTableSeeder::class);
    }
```


## リフレッシュ
```
php artisan migrate:refresh --seed
```

## ソースコードから実行
```php
(new \Database\Seeders\Sample01Seeder())->run();
```

____________________________________________________________
## 記述例
カラム数が異なるレコードは、同時に insertできないみたい。  
```php
    public function run()
    {
        //-----< SP User >-----
        DB::table('users')->where('name', '=', 'kakisoft')->delete();
        DB::table('users')->insert([
            [
                'name' => 'kakisoft',
                'email' => 'foobar@gmail.com',
                'password' => bcrypt('secret'),
                'api_token_1' => str_random(10).'@gmail.com',
            ]
        ]);

        //-----< Normal User >-----
        DB::table('users')->insert([
            [
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('secret'),
            ]
            ,[
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => bcrypt('secret'),
            ],
        ]);
    }
```

