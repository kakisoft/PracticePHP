# pickle
https://github.com/FriendsOfPHP/pickle

## use Amazon Linux
```
amazon-linux-extras enable php8.0
sudo yum install -y php
sudo yum install -y php-bcmath php-dom php-gd php-mbstring php-mysqli php-posix php-sodium php-opcache
sudo yum install -y php-devel
```

## install pickle
```
wget https://github.com/FriendsOfPHP/pickle/releases/latest/download/pickle.phar
php pickle.phar
chmod +x pickle.phar
php pickle.phar info apcu
mv pickle.phar pickle
```

## php-redis install
```
php pickle install redis
echo "extension=redis.so" >> /etc/php.ini
php -m | grep redis
```

