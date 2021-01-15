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

##### migrate
php artisan migrate


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


