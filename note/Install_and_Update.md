# Install

## CentOS
Update もこっちでいいの？
```
sudo yum install -y --enablerepo=remi-php71 php
```

```
この方法でも行ける？
sudo yum install php[バージョン]-php-[extension]
例：
sudo yum install php74-php-mbstring

```

## Ubuntu   
```
sudo apt install php7.4
sudo apt install php7.4-cli
```


## Amazon Linux
```
sudo amazon-linux-extras enable php8.0
sudo yum install php
```

## Windows
```
choco install php --version=5.3.29
```


## macOS
```
which php


php -v


brew upgrade


#### インストール可能な PHPを検索
brew search php

#### PHP のバージョンを指定してインストール
brew install php@7.2
brew install php@8.0


#### シェルの設定を変更
vi ~/.zshrc
export PATH="/usr/local/opt/php@8.0/bin:$PATH"
export PATH="/usr/local/opt/php@8.0/sbin:$PATH"

#### シェルの設定をリフレッシュ
. ~/.zshrc


. ~/.zshrc
```

_________________________________________________________
# Update



_________________________________________________________
# Uninstall

## Ubuntu
```
sudo apt-get remove php7.4-cli
sudo apt-get remove --purge php7.4-cli
```