 * php.ini に "extension=redis.so" の追記が必要かもしれないけど、無くても動く。ただし環境によるかも。


__________________________
## その他注意事項
pecl install redis コマンドにてインストールした後、以下のメッセージが表示されています。

> You should add "extension=redis.so" to 

との事ですが、別に追記せずとも動きました。  
詳細は私も良く分かってないのですが、Laravel が気を利かせて、勝手に読みに行ってるとか？  

[Laravel Redisのライブラリをインストールしたらエラーが発生した](https://qiita.com/miriwo/items/d6ad9e0edc422e8a363a)  

こちらでは、  
『エラーが出たけど、php.ini「extension="redis.so」をコメントアウトしたら直った。』  
という内容が書かれています。  

という事は、Laravel を使う場合は、この設定は不要なのかもしれません。  

ただ、別の環境にアップする時にはエラーが発生するケースがあるようです。  
[AWSにLaravelをデプロイしたらエラーが出たときの対応方法](https://qiita.com/freeneer/items/8162c562337e304b4417)  

EC2 にアップすると動かなかったので、php.ini に extension=redis.so を追記しているようです。  

「本番環境では動かない！」という場合のため、こんな現象があるという事を記憶に留めておいた方がよさそう。  


## php.ini に extension=redis.so を追記
まずは php.ini のパスを確認。  
以下、コマンド。
```
php -i | grep php.ini
```
実行結果例
```
/application $ php -i | grep php.ini
Configuration File (php.ini) Path => /usr/local/etc/php
Loaded Configuration File => /usr/local/etc/php/php.ini
```

上記では、保存パスが「/usr/local/etc/php/php.ini」だったので、追記パスは以下。
```
echo "extension=redis.so" >> /usr/local/etc/php/php.ini
```
追記後は php.ini の内容を確認。  

その後、再起動。  


## 採用選定基準についての所管
PhpRedis 速い！ PhpRedis 最高！　絶対 PhpRedis にするべき！  
みたいな意見もちらほら見かけるけど、結局、OS に手を加えざるを得ず、そこに余計に気を回さないといけなくなり、環境構築の難易度を上げるぐらいなら、いっそ Predis を選択するのもアリなのでは？  
と思った。  

開発が中断されるのが懸念事項に上がってけど、少なくとも今は再開しているし、composer で管理できるしで、色々メリットはある。  

性能は PhpRedis の方が上だけど、システムによってはキャッシュへのアクセスがそこまで頻繁に起こらないケースもあるだろうし、そこまで厳しいアクセススピードの性能が求められないなら、管理コストを下げられるライブラリを選ぶ、というのも１つの選定基準だと思う。  

少なくとも自分は、上記のような理由で PhpRedis ではなく Predis を採用する責任者が居たとしても何ら疑問を持つ事はないし、その意見に反対するつもりも無い。  

ちなみに自分は  
「高速化と軽量化は常に正義！（たとえ厳しく求められないケースであっても。技術負債を抱えてでも実施するべき！）」  
という考え方には否定的です。  





