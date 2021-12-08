【MySQL】null を許可したカラムをユニークキーに含めると、意図しない重複レコードが許可されてしまう（deleted_at）
________________________________________


テーブルにユニークキーを設定する場合、null を許可したカラムを含めると、意図しない重複レコードが作成されてしまう事がある。  

削除処理を論理削除に設定して、deleted_at といったカラムを設定している時に発生するケースがあるかと思われます。  

以下、テーブルとデータの例。  

### 例：Laravel migration ファイル
```php
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->default(0);
            $table->string('code', 80);
            $table->string('name', 100);
            $table->string('sub_name', 50)->nullable();
            $table->integer('price')->default(0);
            $table->integer('category_id')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['owner_id', 'code', 'deleted_at'], 'items_unique_key');
        });
    }
```

### 例：テーブル定義
```sql
CREATE TABLE `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint(20) NOT NULL DEFAULT '0',
  `code` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `category_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `items_unique_key` (`owner_id`,`code`,`deleted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

### 例：データ

キー項目：owner_id, code, item_id, deleted_at  


|  id   |  owner_id  |  code     |  name         |  deleted_at  |
|:------|:-----------|:----------|:--------------|:-------------|
|  1    |  1         |  PRD-001  |  product-001  |  « NULL »    |
|  2    |  1         |  PRD-001  |  product-001  |  « NULL »    |


こんな感じで、キーが重複したレコードが存在できてしまいます。  


## 原因
null が入っている場合、ユニーク制約は効かないようです。  


## 対策
こちらを参考にさせて頂きました。  

[MySQLでLaravel標準のSoftDeletesを使った論理削除とユニーク制約を両立させる方法](https://qiita.com/mpyw/items/d3e25860ecaaeb8340ab)  

「論理削除されていれば NULL， されていなければ 1 になる生成カラムを定義」という方法です。  

### 例：Laravel migration ファイル（変更後）
```php
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->default(0);
            $table->string('code', 80);
            $table->string('name', 100);
            $table->string('sub_name', 50)->nullable();
            $table->integer('price')->default(0);
            $table->integer('category_id')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->boolean('existence')->nullable()->storedAs('CASE WHEN deleted_at IS NULL THEN 1 ELSE NULL END');
            $table->unique(['owner_id', 'code', 'existence'], 'items_unique_key');
        });
```

### 例：テーブル定義（変更後）
```php
CREATE TABLE `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint(20) NOT NULL DEFAULT '0',
  `code` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `category_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `existence` tinyint(1) GENERATED ALWAYS AS ((case when isnull(`deleted_at`) then 1 else NULL end)) STORED,
  PRIMARY KEY (`id`),
  UNIQUE KEY `items_unique_key` (`owner_id`,`code`,`existence`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

「existence」のカラムはユーザが自由に編集する事ができず、deleted_at の値に依存します。  

こうする事で、null を取り得るカラムには強制的に何かしらの値が入るようにし、ユニークキー制御が必ず働くように制御しています。  


