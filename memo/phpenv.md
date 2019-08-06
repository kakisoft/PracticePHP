phpenv でバージョンの切り替えが上手く行かなかったんで、超カッコ悪い方法で対処した。  


＜環境＞
OS：macOS High Sierra


phpenv を使えば、PHPのバージョンの切り替えができるみたいだけど、上手く行かなかったんで小細工して動かしました。


# phpenv
https://github.com/phpenv/phpenv


## 環境構築メモ

### install
```
git clone git://github.com/phpenv/phpenv.git ~/.phpenv
echo 'export PATH="$HOME/.phpenv/bin:$PATH"' >> ~/.bash_profile
echo 'eval "$(phpenv init -)"' >> ~/.bash_profile
exec $SHELL -l


source ~/.bash_profile
```


### php-buildのインストール（オプション扱い？）
https://qiita.com/noraworld/items/26e516e0245ff619f648
```
git clone https://github.com/CHH/php-build.git ~/.phpenv/plugins/php-build


sudo yum -y install gcc libxml2 libxml2-devel libcurl libcurl-devel libpng libpng-devel libmcrypt libmcrypt-devel libtidy libtidy-devel libxslt libxslt-devel openssl-devel bison libjpeg-turbo-devel readline-devel autoconf
```

### phpenvのバージョン確認
```
phpenv --version
```
phpenv v0.9.0-rc.1 と表示された。


### 使用可能なPHP一覧を表示
```
phpenv install --list
```


### 必要なPHPをインストール
```
phpenv install x.x.x
```
5.6.40 をインストールする場合、こんな感じ。
```
phpenv install 5.6.40
```


### PHPのバージョンを切り替え（全域）
```
phpenv global {version}
```

### PHPのバージョンを切り替え（特定のディレクトリのみ）
```
phpenv local {version}
```
特定の階層だけ、5.6.40 する場合、こんな感じ。
```
phpenv local 5.6.40
```


### バージョン確認
```
phpenv version
phpenv versions
```

------------------------
  system
* 5.6.40 (set by /Users/kaki/tmp/phpenv/ver01/.php-version)
------------------------

やったね！　これで、そのディレクトリだけ PHP5 で動くように・・・
ならなかったよ！

具体的にはこんな感じ。
```
> php -v
PHP 7.1.23 (cli) (built: Nov 27 2018 16:59:25) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.1.0, Copyright (c) 1998-2018 Zend Technologies
    with Xdebug v2.5.5, Copyright (c) 2002-2017, by Derick Rethans
```
「php -v」でバージョン確認しても、『PHP 7.1.23』と、システムにインストールしたバージョンが出てくる。

そして、こんなスクリプトを書いてみた。
```php
<?php
  
echo phpversion();
```
単に phpversion を出力するだけのスクリプト。
実行結果は、こんな感じ。

```
> php sample01.php
7.1.23                           
```
ここでも phpenv で指定したバージョンでは動作ぜず。


何でじゃー！

詳しい人に聞いてみると、
「パスの解決順序がおかしいのでは？」
との事で、調べてみた。

まず、php のパスを確認。
```
> which php
/usr/bin/php
```

phpenv のパスはこんな感じだった。
```
bash-3.2$ which phpenv
/Users/kaki/.phpenv/bin/phpenv
```

続いて、環境変数をチェック。
```
> echo $PATH
/usr/local/bin 
/usr/bin 
/bin 
/usr/sbin 
/sbin 
/Users/kaki/.phpenv/bin 
/usr/local/opt/php@5.6/sbin 
/usr/local/opt/php@5.6/bin 
/Users/kaki/.nodebrew/current/bin 
/usr/local/opt/mysql@5.7/bin 
/Users/kaki/.rbenv/bin
（以下略）
```

「.phpenv/bin」のパスが「/usr/bin/」より下なので、この順番を何とかしたら行けるのでは？
との事。

という訳で、「 /etc/paths 」を編集。
こんな感じにしてみた。

```
/usr/local/bin
/Users/kaki/.phpenv/bin
/usr/bin
/bin
/usr/sbin
/sbin
（以下略）
```

結果、変わらず。

グローバルのバージョンを PHP5にしても、バージョンは 7のまま。何故だ！？


## 苦肉の解決策

いくら調べても分かんなかったんで、以下のような超カッコ悪い解決策を取った。


### phpenvでインストールしたPHP5を検索
find コマンドで PHP5 を探す。
```
> sudo find / -name "php"
/usr/local/Cellar/php@5.6/5.6.40/bin/php
```


### /etc/paths を編集
PHP5 が、PHPのパス（ /usr/bin/ ）より上に来るように設定。
```
/usr/local/bin
/usr/local/Cellar/php@5.6/5.6.40/bin
/Users/kaki/.phpenv/bin
/usr/bin
/bin
/usr/sbin
/sbin
（以下略）
```
こんな感じ。


### シェルの設定を反映させる
書き忘れてましたが、bash を使ってます。
```
source ~/.bashrc
source ~/.bash_profile
```


### 実行
```
>php -v
PHP 5.6.40 (cli) (built: Feb 12 2019 19:25:14) 
Copyright (c) 1997-2016 The PHP Group
Zend Engine v2.6.0, Copyright (c) 1998-2016 Zend Technologies
    with Zend OPcache v7.0.6-dev, Copyright (c) 1999-2016, by Zend Technologies
```
という訳で、無事 PHP5.6.40 が実行されました。

上記のスクリプトも、
```
> php sample01.php
5.6.40
```
と、ちゃんとバージョンが変わりました。

めでたしめでた・・・い事は決してなく、その端末で動いてる全PHPのバージョンが 5になっちゃってんだよな・・・。
まぁいいや。そのうち、ちゃんと解決しとこう。
