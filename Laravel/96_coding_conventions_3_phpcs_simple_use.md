## install
```
composer require squizlabs/php_codesniffer --dev
```

## phpcs.xml
src\phpcs.xml
```xml
<?xml version="1.0" encoding="UTF-8" ?>
<ruleset name="PHP_CodeSniffer"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/squizlabs/php_codesniffer/phpcs.xsd">
    <description>Custom ruleset Based on PSR12</description>
    <rule ref="PSR12" />
    <arg name="extensions" value="php" />
    <arg name="colors" />
    <arg value="ps" />
    <exclude-pattern>/_ide_helper.php</exclude-pattern>
    <exclude-pattern>/bin/</exclude-pattern>
    <exclude-pattern>/bootstrap/</exclude-pattern>
    <exclude-pattern>/config/</exclude-pattern>
    <exclude-pattern>/database/</exclude-pattern>
    <exclude-pattern>/node_modules/</exclude-pattern>
    <exclude-pattern>/public/</exclude-pattern>
    <exclude-pattern>/resources/</exclude-pattern>
    <exclude-pattern>/routes/</exclude-pattern>
    <exclude-pattern>/storage/</exclude-pattern>
    <exclude-pattern>/vendor/</exclude-pattern>

    <rule ref="Generic.Files.LineLength">
        <properties>
            <property name="lineLimit" value="180"/>
        </properties>
    </rule>
</ruleset>
```


## コンテナの中から実行
```
./vendor/bin/phpcs --standard=phpcs.xml ./
./vendor/bin/phpcbf --standard=phpcs.xml ./
```

## コンテナの外から実行
```
docker-compose exec -w "/var/www/src" php ./vendor/bin/phpcs --standard=phpcs.xml ./
docker-compose exec -w "/var/www/src" php ./vendor/bin/phpcbf --standard=phpcs.xml ./
```

## Makefile
```
# execute lint
phplint:
	docker-compose exec -w "/var/www/src" php ./vendor/bin/phpcs --standard=phpcs.xml ./

phplintfix:
	docker-compose exec -w "/var/www/src" php ./vendor/bin/phpcbf --standard=phpcs.xml ./
```

