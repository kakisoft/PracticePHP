Laravel スケジューラによるバッチ起動に柔軟性を持たせたい：spliceIntoPosition 編

__________________________________________________________________________________________
**【環境】**  
Laravel のバージョン： 8.16.1  
PHP のバージョン： 7.4.7  


Laravel にて、スケジューラを使用してバッチを起動する場合、以下のようなメソッドにて起動するスパンを指定できる。  

<https://laravel.com/docs/8.x/scheduling>  

 * ->everyMinute();
 * ->everyTenMinutes();
 * ->everyFiveMinutes();
 * ->hourly();

etc  

「このタスクは、５分間隔で実行できるようにしたい or １０分間隔で実行できるようにしたい」といった事を、コンフィグで柔軟に設定したいと思った時、上記のようなメソッドを馬鹿正直に適用すると、こんな感じになる。  

```php
    switch ($helloCommandConf) {
        case EVERY_MINUTE:
            $schedule->command(HelloCommand::class)
                ->description('Hello command Scheduler')
                ->everyMinute();
            break;

        case EVERY_TEN_MINUTES:
            $schedule->command(HelloCommand::class)
                ->description('Hello command Scheduler')
                ->everyTenMinutes();
            break;

        case EVERY_FIVE_MINUTES:
            $schedule->command(HelloCommand::class)
                ->description('Hello command Scheduler')
                ->everyFiveMinutes();
            break;

        default:
            break;
    }
```

**ねーよ！**  

もっと柔軟に実現できる方法はないものか。  
という事で、別の方法を考えてみる。  

## spliceIntoPosition
spliceIntoPosition というメソッドを使えば、もっと柔軟に設定できるみたい。  

 [\[cloudpack開発ブログ]Laravelのスケジューラの小ネタ](https://cloudpack.media/28450)  
[Tips for Using Laravel’s Scheduler](https://laravel-news.com/tips-for-using-laravels-scheduler)

というワケで、早速試してみる。  

しれっと書いてあるので Laravel の標準関数として使えるのかと思いきや、Method not found の非常なエラーが出てきたので、参照方法を調べてみる。  

しかし、どうやったらそのメソッドを参照できるのかの解説は皆無。  


## spliceIntoPosition の参照方法
ロクな情報がヒットしなかったので、最終的に Laravel のソースコードに行きついた。  
https://github.com/laravel/framework/blob/8.x/src/Illuminate/Console/Scheduling/ManagesFrequencies.php  

spliceIntoPosition メソッドを Kernel.php で使用するには、以下の設定が必要になります。  

#### app\Console\Kernel.php
use 宣言を追加
```php
use Illuminate\Console\Scheduling\ManagesFrequencies;
```
トレイト使用宣言を追加
```php
class Kernel extends ConsoleKernel
{
    use ManagesFrequencies;
```
上記のコードを追加すると、spliceIntoPosition が参照できるようになる
```php
    public function everyFourMinutes()
    {
        return $this->spliceIntoPosition(1, '*/4');
    }

    public function weekly()
    {
        return $this->spliceIntoPosition(1, 0)
                    ->spliceIntoPosition(2, 0)
                    ->spliceIntoPosition(5, 0);
    }
```

## spliceIntoPosition って、使えるの？

**結論：使えねー**  

スケジュール設定を柔軟に出来るできるようになるかと思いきや、内部的には cron メソッドの内容を置換しているだけで、わざわざこのメソッドをコール理由は薄い。  
素で「->cron」をコールするだけで十分。  

というか、「everyMinute()」や「everyTenMinutes()」から spliceIntoPosition をコールしているレベルの粒度なので、開発者側が使用する粒度では無いのでは？　という印象。  

以下、ManagesFrequencies.php のソース。  
spliceIntoPosition が存在しているトレイトと同レベルに、「everyMinute()」「everyTenMinutes()」といったメソッドが宣言されています。  


```php
    public function everyMinute()
    {
        return $this->spliceIntoPosition(1, '*');
    }
```

```php
    public function everyTenMinutes()
    {
        return $this->spliceIntoPosition(1, '*/10');
    }
```
```php
    /**
     * Splice the given value into the given position of the expression.
     *
     * @param  int  $position
     * @param  string  $value
     * @return $this
     */
    protected function spliceIntoPosition($position, $value)
    {
        $segments = explode(' ', $this->expression);

        $segments[$position - 1] = $value;

        return $this->cron(implode(' ', $segments));
    }
```

見ての通り、cron メソッドの内容を置換しているだけ。  


## 結論
スケジュール設定に柔軟性を持たせたい場合、cron メソッドを使用しましょう。


