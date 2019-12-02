## add
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
            // $table->string('summary');  //カラム追加

            $table->string('summary')->default('default_value');
            // ↑## SQLite の場合
            // [migrations] SQLite General error: 1 Cannot add a NOT NULL column with default value NULL
            // のエラーを回避。
        });
    }


    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('summary');  //カラムの削除
        });
    }
```

##### migrate
php artisan migrate


_____________________________________________________________________________________

