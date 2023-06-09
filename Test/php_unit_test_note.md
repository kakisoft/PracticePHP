```
クラス名は "テスト対象のクラス名 + Test"
メソッド名は、"test + テストしたいこと"
みたいに書いていくと良いらしい。
```

_____

## Laravel/test
[Laravel/test](../Laravel/71_test_1.md)


## 実行コマンド
Makefile
```
phptest:
	docker-compose exec --user root api bash -c "php artisan test"

```


## 外から実行する時のユーザ
↓のような感じで permission error が出る事があるので、rootユーザで実行。
```
Warning: file_put_contents(/var/www/api/.phpunit.result.cache): Failed to open stream: Permission denied in /var/www/api/vendor/phpunit/phpunit/src/Runner/ResultCache/DefaultResultCache.php on line 140
```



## コンフィグエラー
```
root@5972cc29b69f:/var/www/api# ./vendor/bin/phpunit
PHPUnit 10.2.0 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.2.6
Configuration: /var/www/api/phpunit.xml

Time: 00:16.284, Memory: 24.00 MB

There was 1 PHPUnit test runner deprecation:

1) Your XML configuration validates against a deprecated schema. Migrate your XML configuration using "--migrate-configuration"!

OK, but there are issues!
Tests: 2, Assertions: 2, Deprecations: 1.
```

PHPUnitのテストランナーが非推奨のスキーマに基づいたXML構成ファイルを使用していることを示している。新しいスキーマに移行する必要がある。
以下のコマンドを実行すると、xmlファイルを修正してくれる。
```
./vendor/bin/phpunit --migrate-configuration
```



