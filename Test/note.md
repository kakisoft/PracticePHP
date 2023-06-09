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


