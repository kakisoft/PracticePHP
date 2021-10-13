【Laravel】ジョブのタイムアウトを設定には、特定の条件が必要？

_____________________________________________________________________



ジョブを実行する時、以下のようにタイムアウトの時間（X 秒経過するとエラー）を設定できる。  
```
php artisan queue:listen --timeout=60
```

他にも、タイムアウト時間を、コードに記述する事もできる。  

```php
namespace App\Jobs;

class ProcessPodcast implements ShouldQueue
{
    /**
     * タイムアウトになる前にジョブを実行できる秒数
     *
     * @var int
     */
    public $timeout = 120;
}
```

＜公式サイト＞  
https://readouble.com/laravel/8.x/ja/queues.html#cleaning-up-after-failed-jobs  


が、実験したところ、ソースコードにて指定された「120」が有効とならなかった。  
何か条件があるかもしれないし、




pcntl


php -m | grep pcntl




https://rj-bl.hatenablog.com/entry/2017/04/09/165858

https://stackoverflow.com/questions/40408152/how-to-enable-pcntl-on-ubuntu-server-16-04

https://stackoverflow.com/questions/33036773/how-to-enable-pcntl-in-php-while-using-a-framework-like-symfony2

