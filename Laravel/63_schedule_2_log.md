

## Laravelでスケジュールの出力をログに残す
https://qiita.com/horikeso/items/054e252043f19acd920c


新規

$schedule->command('command:batch')->dailyAt($time)->sendOutputTo($schedule_log_path);
追記

$schedule->command('command:batch')->dailyAt($time)->appendOutputTo($schedule_log_path);



## Laravelでschedule:runしたときのoutputがdockerで標準出力されない問題を解消
https://qiita.com/imunew/items/6b210ea05b70885ce990



## Laravel ログを出力する
https://qiita.com/ucan-lab/items/99f9f4989a894de1aea0


## Laravelのログ設定を徹底的に理解する
https://reffect.co.jp/laravel/laravel-logging-setting



## Laravelでログを標準出力（stdout）させる方法
https://www.engilaboo.com/laravel-log-stdout/


