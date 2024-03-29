## create
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()  // up() このマイグレーションで行いたい処理
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');   // add
            $table->text('body');      // add
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()  // down() はそれを巻き戻すための処理
    {
        Schema::dropIfExists('posts');
    }
}
```
_____________________________________________________________________________________
## update
```
# 既存のテーブルに変更を加える場合には、--create オプションではなく、--table オプションを使って、テーブル名を指定する。
php artisan make:migration add_user_id_to_posts_table --table=posts
```

#### migrations ファイルを編集
```php
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // カラム追加（MySQL の場合。Posgreも多分大丈夫）
            // $table->string('summary');


            // カラム追加（SQLite の場合）
            // [migrations] SQLite General error: 1 Cannot add a NOT NULL column with default value NULL
            // のエラーを回避。
            $table->string('summary')->default('default_value');
        });
    }


    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // カラムの削除
            $table->dropColumn('summary');
        });
    }
```


## _
```
php artisan make:migration add_column_avatar_artists_table --table=artists
```

#### migrations ファイルを編集
```php
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {

            $table->text('avatar')
                ->after('name')
                ->comment('写真');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artists', function (Blueprint $table) {

            $table->dropColumn('avatar');

        });
    }
```


##### migrate
php artisan migrate


##### rollback
php artisan migrate:rollback --step=1

_____________________________________________________________________________________
## 外部制約付き
```php
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('post_id');     // 外部キーはマイナスにならないので、unsignedInteger を使うことも。
            $table->string('body');
            $table->timestamps();

            $table
              ->foreign('post_id')
              ->references('id')
              ->on('posts')
              ->onDelete('cascade');    // 依存関係のあるレコードが削除された時、同時に Delete。
        });
    }
```

_____________________________________________________________________________________
## 特定の位置にカラムを追加
MySQL のみ？

```php
    Schema::table('users', function (Blueprint $table) {
        $table->text('email')->after('last_name');
    });
```

_____________________________________________________________________________________
## スキーマ定義を変更
null を許容したり
```php
class AlterApiToken1ToUserTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_token_1')->nullable()->default(null)->change();
            $table->dateTime('api_token_1_expiration_date')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('api_token_1')->nullable(false)->change();
            $table->dateTime('api_token_1_expiration_date')->nullable(false)->change();
        });
    }
}
```
_____________________________________________________________________________________
## カラム名変更

```php
$table->renameColumn('from', 'to');
```

カラム名を変更する時、
```
Class 'Doctrine\DBAL\Driver\AbstractMySQLDriver' not found
```
といったメッセージが出たら、composer で以下を追加。  
（laravel、はデフォルトではカラム名の変更や削除はできない）

#### composer
```
composer require doctrine/dbal
```

_____________________________________________________________________________________
## null 許容
null 許容
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('name', 50)->nullable()->change();
});
```

null を許容しない  
※php artisan migrate:rollback で戻す場合、null を許容しないレコードが null だったら、rollback がコケる
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('name', 50)->nullable(false)->change();
});
```

_____________________________________________________________________________________
## テーブルにコメントを追加
Laravel コマンドは無いみたいで、ALTER TABLE コマンドを使うしかないみたい。  
ちょっと嫌。（↓は MySQL）
```php
    public function up()
    {
        DB::statement("ALTER TABLE `items` COMMENT '商品マスタ'");
    }
```

_____________________________________________________________________________________
## カラムにコメントを追加
```php
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('name',40);
            $table->integer('sort')->unsigned()->comment('並び順');
            $table->integer('code')->unsigned()->comment('コード');
        });
```

#### 後付け
```php
        Schema::table('companies', function (Blueprint $table) {
            $table->string('name')->comment('名称')->change();
        });
```
元々持っていた定義が消える。  
・・・こんな方法しか無いんか？  


#### MySQL：ALTER TABLE コマンドを使用
```php
    DB::statement("ALTER TABLE `users` CHANGE first_name first_name varchar(40) COMMENT 'ファーストネーム'");
```


#### パラメータを列挙して change()
これが一番ミスが少なそう。
```php
    Schema::table('residential_building_calculation_settings', function (Blueprint $table) {
        $table->boolean('is_calculate_water_heater_enabled')
                ->default(false)
                ->comment('住宅一次エネルギー消費量（給湯設備の計算を行う）')
                ->change();
    });
```

_____________________________________________________________________________________
## ドライバを指定
MySQL の時だけ実行するコマンドを設定する
```php
    // Return if the database driver is not MySQL.
    if (DB::getDriverName() !== 'mysql') {
        return;
    }

    DB::statement("ALTER TABLE `users` COMMENT 'ユーザマスタ'");
```
'sqlite'
も。
Maria とかも試してみるか。

_____________________________________________________________________________________
## 論理削除のオプションを付加
```php
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
        });
```

_____________________________________________________________________________________
## ユニークキー
```
php artisan make:migration add_uniquekey_to_posts_table --table=posts
```

メソッドチェーン
```php
$table->string('email')->unique();
```

後から
```php
$table->unique('email');
```

複数キー
```php
$table->unique(['owner_id', 'product_code']);


// デフォルト設定の場合、キーの名前が長くなって許可上限を超えてしまったため、エイリアス（第二引数）を付けています
$table->unique(['owner_id', 'inventory_type', 'expiration_date', 'lot_no', 'location'], 'inventories_unique_key');


// 論理削除場合、ユニークキーに deleted_at を含める。
$table->unique(['owner_id', 'product_code', 'deleted_at'], 'items_unique_key');

```

## ユニークキーを削除
```php
$table->dropUnique(['other_id']);
```

_____________________________________________________________________________________
## 参照
https://laravel.com/docs/8.x/migrations

### id()
The id method is an alias of the bigIncrements method. By default, the method will create an id column; however, you may pass a column name if you would like to assign a different name to the column:
```php
$table->id();
```

### increments()
The increments method creates an auto-incrementing UNSIGNED INTEGER equivalent column as a primary key:
```php
$table->increments('id');
```


_____________________________________________________________________________________
# よく使う型

```php
$table->id();
$table->timestamps();
$table->softDeletes();
$table->unsignedBigInteger('product_id')->comment('プロダクトID');
$table->integer('inventory_type')->comment('在庫区分');
$table->date('flavor_expiration_date')->nullable()->comment('賞味期限');
$table->date('expiration_date')->nullable()->comment('消費期限');
$table->dateTime('reported_datetime')->nullable()->comment('報告日時');
$table->string('name', 255)->nullable()->comment('名称');
$table->text('key')->nullable()->comment('キー');
$table->text('value')->nullable()->comment('値');
$table->integer('quantity_per_case')->nullable()->default(1)->comment('ケース入数');
```

_____________________________________________________________________________________
# よく使うコマンド

## migrate / rollback
```
php artisan migrate
php artisan migrate:rollback --step=1

php artisan migrate:rollback
```

## add / edit
```
php artisan make:model ShipperJobSchedulerSetting --migration

php artisan make:migration add_user_id_to_posts_table --table=posts
```

## リフレッシュ
```
php artisan migrate:refresh --seed

php artisan migrate:fresh
```