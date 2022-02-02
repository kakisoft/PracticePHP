## --
```
現象：PHPのソースがそのままブラウザに表示される。

〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
sudo find / -name "libphp5.so"


libphp5.so
なし


libphp7.so
/usr/lib64/httpd/modules/libphp7.so   # 実態
/etc/httpd/modules/libphp7.so         # リンク

〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
[vagrant@localhost ~]$ php -v
PHP 5.6.37 (cli) (built: Jul 19 2018 20:06:19)

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
sudo vi /etc/php.ini

AddType application/x-httpd-php .php
AddType application/x-httpd-php-source .phps


<FilesMatch \.php$>
    SetHandler application/x-httpd-php
</FilesMatch>


<VirtualHost *:8080>
    ServerName miniblog.myhost
    DocumentRoot "/vagrant/shared"
    #DocumentRoot "/vagrant/shared/miniblog/www"
</VirtualHost>

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
sudo vi /etc/httpd/conf/httpd.conf


; This directive determines whether or not PHP will recognize code between
; <? and ?> tags as PHP source which should be processed as such. It is
; generally recommended that <?php and ?> should be used and that this feature
; should be disabled, as enabling it may result in issues when generating XML
; documents, however this remains supported for backward compatibility reasons.
; Note that this directive does not control the <?= shorthand tag, which can be
; used regardless of this directive.
; Default Value: On
; Development Value: Off
; Production Value: Off
; http://php.net/short-open-tag
#short_open_tag = Off
short_open_tag = On






sudo port install php55-apache2handler
sudo port install php56-apache2handler



<http://www.ksknet.net/apache/php_1.html>



sudo yum install --enablerepo=remi --enablerepo=remi-php56 php php-devel php-mbstring php-mcrypt php-mysql

（エラー発生時は以下で）
sudo yum install --skip-broken --enablerepo=remi --enablerepo=remi-php56 php php-devel php-mbstring php-mcrypt php-mysql




〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓

＜OK＞
http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm
http://rpms.famillecollet.com/enterprise/remi-release-6.rpm

＜NG＞
http://ftp.iij.ad.jp/pub/linux/fedora/epel/7/x86_64/e/epel-release-7-5.noarch.rpm
http://rpms.famillecollet.com/enterprise/remi-release-7.rpm



（Not Found）
sudo rpm -Uvh http://dl.fedoraproject.org/pub/linux/fedora/epel/7/x86_64/e/epel-release-7-5.noarch.rpm
sudo rpm -Uvh http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm


〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓

＜インストール可能なリスト＞
sudo yum list | grep php56

2.3-1.el6.remi

sudo rpm -Uvh 2.3-1.el6.remi




php56.x86_64                                2.3-1.el6.remi             remi-safe




php56-php-cli.x86_64
php56-runtime.x86_64
php56-php-common.x86_64
php56-php-devel.x86_64

php56-php-pecl-http.x86_64
php56-php-pecl-http-devel.x86_64




━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
CentOS6.6に php5.5をインストールしてみる。
https://qiita.com/ddss/items/6c704334a0fde4a29dc0

CentOS7にPHP5.6をインストールする。
https://qiita.com/koichi_amami/items/e97bc70e82e95ab99f55



↓のやり方では NG
sudo yum install --enablerepo=remi --enablerepo=remi-php56 
php 
php-opcache 
php-devel 
php-mbstring 
php-mcrypt 
php-mysqlnd 
php-phpunit-PHPUnit 
php-pecl-xdebug 
php-pecl-xhprof




sudo yum list | grep php56
これで探す

___________________________________________________________

```


