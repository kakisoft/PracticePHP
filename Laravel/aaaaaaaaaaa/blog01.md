docker コンテナにログインした時の、デフォルトユーザを設定する。（docker-compose.yml）
how-to-set-default-login-user-in-docker-container

__________________________________________________________________________________________

docker コンテナにログインする時、特にユーザを指定が無い場合、root ユーザでのログインになる事があるかと思います。

ですが、docker-compose.yml にて、コンテナにログインした時のデフォルトユーザを設定可能です。

以下、記述例。
「user:」に、デフォルトログインユーザを記述します。
デフォルトログインユーザを「www-data」としています。

#### docker-compose.yml
```yaml
services:

# 中略

  app:
    build: ./docker/php
    depends_on:
    - mysql
    volumes:
      - .:/var/www/html
    container_name: myapp
    user: www-data

# 以下略
```


ログインした後、whoami コマンドで、ユーザを確認
```
$ whoami
www-data
```

root でログインする場合、--user オプションでユーザを指定。
```
docker-compose exec --user root app bash
```

docker-compose でなく、docker コマンドを使う場合、こんな感じ。
```
docker exec -u root -it myapp bash
```

個人的には、コンテナ名を指定しないといけない docker exec よりも、docker-compose.yml の内容をそのまま使える docker-compose exec の方が好み。
（container_name を明示していない docker-compose.yml も多いし。）

コンテナに入ってキューのワーカーを動かしていた場合、root ユーザで実行していると、ログやキャッシュのオーナーが root になっているので、変更後のユーザでワーカー等のファイルが生成される可能性のあるコマンドを打つ場合、あらかじめ作成されたファイルを削除しておくのがおススメ。

Laravel で言うと、以下のようなフォルダに格納されたファイル。

 * storage/logs
 * storage/framework/cache

