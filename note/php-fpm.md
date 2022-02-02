# php-fpm

## FPM (FastCGI Process Manager)  php-fpm / php7.1-fpm
FPM (FastCGI Process Manager) は PHP の FastCGI 実装のひとつで、 主に高負荷のサイトで有用な追加機能を用意しています。  
  
この SAPI は、PHP 5.3.3 以降にバンドルされています。
　  
（参考）  
<https://qiita.com/kotarella1110/items/634f6fafeb33ae0f51dc>  
　   

## www.conf
php-fpm を使う時のコンフィグファイル

## www.conf の設定
```
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3
```

## パフォーマンス

| 項目  | 数値 |
| ------------- | ------------- |
| 1. 現在の使用メモリ量(最も使用しているasims-backend)  | 223～235 MB程度  |
| 2. 1プロセスあたりの使用量(想定)  | 60  |
| 3. コンテナの余力(想定)  | 34.13  |

 1.  New Relic から出力されている数字。（コンテナ内部の数字。AWSコンソールからは確認不可）
 2. 『（1の数字のバッファ）/  （プロセス数） 』で算出。300 / 5  = 60。
 3. 『（コンテナのメモリ）/ （2 の数字）』で算出。2048 / 60 。

## 変更後の値
以下の値が妥当かと思われる

```
pm = dynamic  
pm.max_children = 25  
pm.start_servers = 10  
pm.min_spare_servers = 5  
pm.max_spare_servers = 25  
pm.max_requests = 10000  
```

調整する場合、pm.max_children の値と pm.min_spare_servers の値を増減させる。（値を同一にする）  
負荷が小さければ値を増加し、負荷が大きければ値を現象させる。  


## New Relic を使わずに確認する方法
ECS からも確認する事が出来る。  
ただし、こちらはコンテナ単位ではなく、クラスタ（複数のコンテナのかたまり）単位での計測となる。  

#### 警告が発生される値
CPU使用率：80% 以上  
メモリ使用量、1.7G 以上  

#### ピーク時の数字を、この数字に抑えてく
CPU使用率：75% 以上  
メモリ使用量、1.4G 以上  
※ずっとこの数字が続くのは望ましくない。ピーク時に備えておく  

## 適切な値の算出例
メモリ使用率：2048  
使用率：8%  
現在のプロセス数：25  
の場合  

 1. メモリ使用量を算出（2018 * 0.08 = 163.84）
 2. 現在のプロレス数で割り、１プロセス当たりの使用量を算出。（163.84 / 25 = 6.5536）
 3. 「2」で算出した数字を基に、いくつプロセスを増やしても問題ないかを判断する。

## パラメータの説明

|      パラメータ       | 内容 |
| --------------------- | ------------- |
| pm                    |  "dynamic" の時、負荷によってプロセスが増減する。"static" の時、プロセス数は常に pm.max_children の数となる  |
| pm.max_children       |  作成される子プロセスの最大数  |
| pm.start_servers      |  開始時のプロセス数  |
| pm.min_spare_servers  |  アイドル時に立ち上げておく子プロセス数の最小値  |
| pm.max_spare_servers  |  アイドル時に立ち上げておく子プロセス数の最大値  |
| pm.max_requests       |  各子プロセスが、再起動するまでに実行するリクエスト数。（値が 10000の場合、10000リクエストを受けるとそのプロセスは終了し、新しいプロセスを作成する。パフォーマンスが落ちている場合、増やしてもよい）  |



__________________________

参考記事  
https://qiita.com/Qiita_Sui/items/29ec160c4e830c138132  
https://hackers-high.com/linux/php-fpm-config/  
https://webkaru.net/linux/php-fpm-increase-pm-start-servers-warning/  

