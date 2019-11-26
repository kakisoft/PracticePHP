
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

