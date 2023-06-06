# PHPStan

## install
```
composer require --dev phpstan/phpstan
```

## version check
```
./vendor/bin/phpstan analyse --version
```

## execute
```
./vendor/bin/phpstan analyse
./vendor/bin/phpstan analyse -l 4

./vendor/bin/phpstan analyze --memory-limit=1024M
```

## execute from out of container
```
docker-compose exec -w "/var/www/src" php ./vendor/bin/phpstan analyse --memory-limit=1024M
```

## phpstan.neon
src\phpstan.neon
```
parameters:
    level: 7
    paths:
        - app
        - tests
    excludes_analyse:
        - */some/excluded/file.php
        - */another/excluded/directory
```


## level

0（無効）: エラーチェックを無効にします。
1（最低）: 致命的なエラーのみを表示します。
2（低）: 致命的なエラーとエラーを表示します。
3（中）: 致命的なエラー、エラー、警告を表示します。
4（高）: 致命的なエラー、エラー、警告、注意を表示します。
5（最高）: 致命的なエラー、エラー、警告、注意、情報を表示します。
6（すべて）: 全てのレベルのエラーと警告を表示します。
7（すべて + 冗長）: 全てのレベルのエラーと警告を表示しますが、冗長な情報は表示しません。
8（すべて + 冗長 + ドキュメント）: 全てのレベルのエラーと警告を表示し、冗長な情報とドキュメントブロック内のエラーも表示します。


## Make
```
phpanalyse:
    docker-compose exec -w "/var/www/src" php ./vendor/bin/phpstan analyse --memory-limit=1024M
    # chmod 777 -R /tmp/phpstan
```


