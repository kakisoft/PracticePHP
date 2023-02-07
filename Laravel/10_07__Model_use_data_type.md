## Model 定義に使えるデータ型
https://readouble.com/laravel/5.5/ja/migrations.html


|  コマンド                                      |  説明                                                   |
|:-------------------------------------------|:------------------------------------------------------|
|  $table->bigIncrements('id');              |  符号なしBIGINTを使用した自動増分ID（主キー）                           |
|  $table->bigInteger('votes');              |  BIGINTカラム                                            |
|  $table->binary('data');                   |  BLOBカラム                                              |
|  $table->boolean('confirmed');             |  BOOLEANカラム                                           |
|  $table->char('name', 100);                |  オプションの文字長を指定するCHARカラム                                |
|  $table->date('created_at');               |  DATEカラム                                              |
|  $table->dateTime('created_at');           |  DATETIMEカラム                                          |
|  $table->dateTimeTz('created_at');         |  タイムゾーン付きDATETIMEカラム                                  |
|  $table->decimal('amount', 8, 2);          |  有効（全体桁数）／小数点以下桁数指定のDECIMALカラム                        |
|  $table->double('amount', 8, 2);           |  有効（全体桁数）／小数点以下桁数指定のDOUBLEカラム                         |
|  $table->enum('level', ['easy', 'hard']);  |  ENUMカラム                                              |
|  $table->float('amount', 8, 2);            |  有効（全体桁数）／小数点以下桁数指定のFLOATカラム                          |
|  $table->geometry('positions');            |  GEOMETRYカラム                                          |
|  $table->geometryCollection('positions');  |  GEOMETRYCOLLECTIONカラム                                |
|  $table->increments('id');                 |  符号なしINTを使用した自動増分ID（主キー）                              |
|  $table->integer('votes');                 |  INTEGERカラム                                           |
|  $table->ipAddress('visitor');             |  IPアドレスカラム                                            |
|  $table->json('options');                  |  JSONフィールド                                            |
|  $table->jsonb('options');                 |  JSONBフィールド                                           |
|  $table->lineString('positions');          |  LINESTRINGカラム                                        |
|  $table->longText('description');          |  LONGTEXTカラム                                          |
|  $table->macAddress('device');             |  MACアドレスカラム                                           |
|  $table->mediumIncrements('id');           |  符号なしMEDIUMINTを使用した自動増分ID（主キー）                        |
|  $table->mediumInteger('votes');           |  MEDIUMINTカラム                                         |
|  $table->mediumText('description');        |  MEDIUMTEXTカラム                                        |
|  $table->morphs('taggable');               |  符号なしINTERGERのtaggable_idと文字列のtaggable_typeを追加        |
|  $table->multiLineString('positions');     |  MULTILINESTRINGカラム                                   |
|  $table->multiPoint('positions');          |  MULTIPOINTカラム                                        |
|  $table->multiPolygon('positions');        |  MULTIPOLYGONカラム                                      |
|  $table->nullableMorphs('taggable');       |  NULL値可能なmorphs()カラム                                  |
|  $table->nullableTimestamps();             |  timestamps()メソッドの別名                                  |
|  $table->point('position');                |  POINTカラム                                             |
|  $table->polygon('positions');             |  POLYGONカラム                                           |
|  $table->rememberToken();                  |  VARCHAR(100)でNULL値可能なremember_tokenを追加               |
|  $table->smallIncrements('id');            |  符号なしSMALLINTを使用した自動増分ID（主キー）                         |
|  $table->smallInteger('votes');            |  SMALLINTカラム                                          |
|  $table->softDeletes();                    |  ソフトデリートのためにNULL値可能なdeleted_at TIMESTAMPカラム追加         |
|  $table->softDeletesTz();                  |  ソフトデリートのためにNULL値可能なdeleted_atタイムゾーン付きTIMESTAMPカラム追加  |
|  $table->string('name', 100);              |  オプションの文字長を指定したVARCHARカラム                             |
|  $table->text('description');              |  TEXTカラム                                              |
|  $table->time('sunrise');                  |  TIMEカラム                                              |
|  $table->timeTz('sunrise');                |  タイムゾーン付きTIMEカラム                                      |
|  $table->timestamp('added_on');            |  TIMESTAMPカラム                                         |
|  $table->timestampTz('added_on');          |  タイムゾーン付きTIMESTAMPカラム                                 |
|  $table->timestamps();                     |  NULL値可能なcreated_atとupdated_atカラム追加                   |
|  $table->timestampsTz();                   |  タイムゾーン付きのNULL値可能なcreated_atとupdated_atカラム追加          |
|  $table->tinyIncrements('id');             |  符号なしTINYINTを使用した自動増分ID（主キー）                          |
|  $table->tinyInteger('votes');             |  TINYINTカラム                                           |
|  $table->unsignedBigInteger('votes');      |  符号なしBIGINTカラム                                        |
|  $table->unsignedDecimal('amount', 8, 2);  |  有効（全体桁数）／小数点以下桁数指定の符号なしDECIMALカラム                    |
|  $table->unsignedInteger('votes');         |  符号なしINTカラム                                           |
|  $table->unsignedMediumInteger('votes');   |  符号なしMEDIUMINTカラム                                     |
|  $table->unsignedSmallInteger('votes');    |  符号なしSMALLINTカラム                                      |
|  $table->unsignedTinyInteger('votes');     |  符号なしTINYINTカラム                                       |
|  $table->uuid('id');                       |  UUIDカラム                                              |
|  $table->year('birth_year');               |  YEARカラム                                              |


## MySQL 5.7

|        Laravel 8.16          |      COLUMN_TYPE      |       EXTRA      |
|------------------------------|-----------------------|------------------|
|  $table->id()                |  bigint(20) unsigned  |  auto_increment  |
|  $table->unsignedBigInteger  |  bigint(20) unsigned  |                  |
|  $table->bigInteger          |  bigint(20)           |                  |
|  $table->bigIncrements       |  bigint(20) unsigned  |  auto_increment  |
|  $table->increments          |  int(10) unsigned     |  auto_increment  |


# サイズ

<https://dev.mysql.com/doc/refman/8.0/en/integer-types.html>  

|  Type       |  Storage (Bytes)  |  Minimum Value Signed  |  Minimum Value Unsigned  |  Maximum Value Signed  |  Maximum Value Unsigned  |
|:------------|:------------------|:-----------------------|:-------------------------|:-----------------------|:-------------------------|
|  TINYINT    |  1                |  -128                  |  0                       |  127                   |  255                     |
|  SMALLINT   |  2                |  -32768                |  0                       |  32767                 |  65535                   |
|  MEDIUMINT  |  3                |  -8388608              |  0                       |  8388607               |  16777215                |
|  INT        |  4                |  -2147483648           |  0                       |  2147483647            |  4294967295              |
|  BIGINT     |  8                |  -263                  |  0                       |  2^63 - 1              |  2^64 -1                 |


 * MySQL の一部の型は、型によって既にサイズが確定しており、サイズを好き勝手に変える事は出来ない。
 * 2^63 - 1 = 922,3372,0368,5477,5808  - 1
 * 2^64 - 1 = 1844,6744,0737,0955,1616 - 1

INT で範囲指定をするなら、「1～999999999（9桁）」ぐらいにしておくのが無難か。


## カラム修飾子
```php
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
```

______________________________________________________________
# Enum （ MySQL ）
こうすると、null は許可するみたい。
```php
$table->enum('gender_type', [1, 2, 3])->nullable();
```

```sql
`gender_type` enum('1','2','3') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
```

