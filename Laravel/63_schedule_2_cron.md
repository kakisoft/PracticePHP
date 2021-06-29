## cron
```
min hour day month youbi ＜command＞
（※ 0 or 7 が日で、1 が月、2 が）


＜例＞
毎朝 7 時に実行したい場合、
0 7 * * * ＜command＞
```

## _
```
Example of job definition:
.---------------- minute (0 - 59)
|  .------------- hour (0 - 23)
|  |  .---------- day of month (1 - 31)
|  |  |  .------- month (1 - 12) OR jan,feb,mar,apr ...
|  |  |  |  .---- day of week (0 - 6) (Sunday=0 or 7) OR sun,mon,tue,wed,thu,fri,sat
|  |  |  |  |
*  *  *  *  * user-name command to be executed
```

