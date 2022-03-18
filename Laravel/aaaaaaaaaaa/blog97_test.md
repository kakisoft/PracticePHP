prueba





______________________________________
Laravel にてテストコードを実行する時、  
「テスト実行前にコンフィグをキャッシュした時、".env" から値を参照し、テスト実行前にコンフィグをキャッシュしなかった時、"phpunit.xml" から値を参照する」  
という、知っておかないとドハマリする、なかなかに闇が深い挙動をしたりする。  

例えば、以下のコード。  

### tests/Sample01Test.php
```php
    public function testPrueba01()
    {
        $token = config('docurain.token');
        echo "===================================" . PHP_EOL;
        echo "token:{$token}" . PHP_EOL;
        echo "===================================" . PHP_EOL;
    }
```

### config/docurain.php
```php
return [
    'token' => env('DOCURAIN_TOKEN'),
];
```

### .env
※アクセストークン。適当に作成した値です
```.env
DOCURAIN_TOKEN=FohVai3zei7dei8zainanuaphohqu5uz1Goh9aiy
```

### phpunit.xml
```xml
    <php>
        <server name="APP_ENV" value="testing"/>
        <server name="BCRYPT_ROUNDS" value="4"/>
        <server name="CACHE_DRIVER" value="array"/>
        <server name="MAIL_MAILER" value="array"/>
        <server name="QUEUE_CONNECTION" value="sync"/>
        <server name="SESSION_DRIVER" value="array"/>
        <server name="TELESCOPE_ENABLED" value="false"/>
    </php>
```

テストコード実行前に、コンフィグをキャッシュするか、しないかで実行結果が変わってくる。

## コンフィグをキャッシュする場合
実行コマンド
```
php artisan config:clear | php artisan config:cache
php artisan test tests/Sample01Test.php
```
実行結果
```
===================================
token:FohVai3zei7dei8zainanuaphohqu5uz1Goh9aiy
===================================
```

## コンフィグをキャッシュしない場合
実行コマンド
```
php artisan config:clear
php artisan test tests/Sample01Test.php
```
実行結果
```
===================================
token:
===================================
```

## 何が起こっているか
コンフィグをキャッシュする場合、.env 内の「DOCURAIN_TOKEN」の値を参照する。  

コンフィグをキャッシュしない場合、phpunit.xml 内の 「server name="DOCURAIN_TOKEN"」の値を参照する。  
ただ、上記の場合では phpunit.xml にそんな値を設定していないので、空の値が出力されてしまう。  


## 対策１． phpunit.xml に追記する。
例えば、こんな感じ。  
```xml
    <php>
        <server name="DOCURAIN_TOKEN" value="FohVai3zei7dei8zainanuaphohqu5uz1Goh9aiy"/>
    </php>
```
見えようが見えまいがどうでもいい情報ならまだしも、アクセストークンとか超入れたくない。  

解決はできるものの、とんでもなく気持ち悪い。  


## 対策２． テストコードの実行範囲を限定する。（CI/CD の対象から切り離す）
テストコードを CI/CD に組み込んで実行する場合、実行コマンドはこんな感じになるかと思います。
```
php artisan test
```
ユニットテスト、機能テストで分ける場合、こんな感じ。
```
php artisan test tests/Unit
php artisan test tests/Feature
```

phpunit.xml は、こんな感じ。

### phpunit.xml
```xml
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
        </testsuite>
    </testsuites>
```

この場合、テストコード実行の対象は、以下のディレクトリとなります。  
/tests/Unit/*  
/tests/Feature/*  

.env から値を取得する必要があるものの、phpunit.xml にその値を書きたくない、といった情報（サービスへのアクセストークンなど）が必要なテストは、上記のフォルダとは切り離した場所に保存する。例えば、こんな感じ。  
/tests/Docurain/EstimateTestExtra.php  

こういう事に気を回さないといけないケースは、おそらく外部サービスへのアクセスが必要で、その時にトークンやシークレットキーといった情報が必要になる時ぐらいかと思われます。  

ただ、その場合、アクセス回数に制限があったり、アクセス数によって課金される金額が変わってきたりと、CI/CD に組み込むにはちょっと慎重にした方がいいケースが多いのではないかと思われます。  

なので、CI/CD とは切り離し、その機能はテストを手動で実行、または通常のフローとは別の箇所で実行、と切り離した方がいいんじゃないかと思います。  


