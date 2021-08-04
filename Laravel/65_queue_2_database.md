キューをデータベースで使う時の手順。

## テーブルを作成
「queue:table」の artisan コマンドを叩くと、テーブル「jobs」の migration ファイルが作成される。  
その後、migrate。  
```
php artisan queue:table
php artisan migrate
```

ちなみに、こんな感じの内容です。
```php
class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });
    }
```

## 設定変更
キューの接続を database 変更。

.env ファイルを編集。
#### .env
```
QUEUE_CONNECTION=database
```

config\queue.php を編集。  
先ほど、「jobs」というテーブルを作成ましたが、別のテーブルで扱う事も可能です。  
#### config\queue.php
```conf
        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
        ],
```

以上で、キューをデータベースで扱う場合の設定は完了です。  

次回、これを使っていきます。  
