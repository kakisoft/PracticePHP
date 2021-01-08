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
