【Laravel】ジョブのタイムアウトを設定には、pcnt（PHPの拡張項目）を有効化する必要がある

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
優先順位としては、コードに記述した時間の方が高くなる。  

例えば、「php artisan queue:listen --timeout=60」とコマンドを打っても、ソースコードでは「$timeout = 120」となっていた場合、タイムアウト時間は 120秒となる。  


**＜Laravel 公式サイト＞**  
<https://readouble.com/laravel/8.x/ja/queues.html#cleaning-up-after-failed-jobs>  

が、実験したところ、ソースコードにて指定された「120」が有効とならなかった。  

実はこの設定だけでは不十分で、「pcnt」という PHPの拡張項目を有効にする必要がある。  
詳細は以下を参照。  


**\# Timeout**
<https://laravel.com/docs/8.x/queues#timeout>  
```
The pcntl PHP extension must be installed in order to specify job timeouts.
```

pcntl を有効にするには、以下を参照してください。  
[PHP・Docker：Docker コンテナ起動の PHP にて、pcntl を有効にする方法](https://www.kakistamp.com/entry/2021/12/28/125832)  

この設定を有効化すると、ジョブ実行のタイムアウト時間を設定する事ができます。  

## 失敗したジョブを再実行
失敗したジョブを全て実行する場合、以下のコマンドを実行すると、失敗ジョブが再びキューに戻る。  
```
php artisan queue:retry all
```

その後、「queue:work」や「queue:listen」等で、再び実行できる。  
```
php artisan queue:listen
```





## 失敗したジョブの再試行
```
php artisan queue:failed
```



## 失敗ジョブの確認
```
php artisan queue:failed
```

```
root@6ebd042018af:/var/www/html/my-laravel-app# php artisan queue:failed
+--------------------------------------+------------+---------+------------------+---------------------+
| ID                                   | Connection | Queue   | Class            | Failed At           |
+--------------------------------------+------------+---------+------------------+---------------------+
| 930ab89d-ec4e-4899-b943-d0f7c533a682 | database   | default | App\Jobs\MyJob12 | 2021-12-28 05:18:29 |
| be2efe30-b3c0-4bfd-9cbc-7fc9f3608c1b | database   | default | App\Jobs\MyJob12 | 2021-12-28 05:12:23 |
+--------------------------------------+------------+---------+------------------+---------------------+
```

