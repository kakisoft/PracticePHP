## Laravel 公式
https://readouble.com/laravel/8.x/ja/database-testing.html

## Faker
https://github.com/fzaninotto/Faker


_______________________________________________________________
## ファクトリクラスを作成
```
php artisan make:factory Sample
```

database\factories\SampleFactory.php  

が作成される。  

_______________________________________________________________
# Facker の日本語化

## config\app.php
```php
'faker_locale' => 'en_US',

　　　　　　↓

'faker_locale' => 'ja_JP',
```


_______________________________________________________________
## database\factories\SampleFactory.php
例
```php
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'special_name' => $this->faker->unique()->name,
            'title'=>$this->faker->text(20),
            'body'=>$this->faker->text(50),
            'user_id'=>User::factory(),
            'gender_code' => $this->faker->numberBetween(1, 3),
            'birthday' => $this->faker->dateTimeBetween('-12 years', '0years')->format('Y-m-d'),


            'account_id' => function() {
                return Account::factory()->create()->id;
            },
        ];
    }
```

## ユニークパラメータを指定
```php
$faker->unique()->firstName;
```


## よく使いそうな構成
```php
$faker->word()                 // 単語
$faker->sentence(n)            // 単語数指定した文章
$faker->text($max)             // $max文字数までの文章
$faker->name()                 // 名前 
$faker->realText()             // 文字数指定した文章　デフォルトは200
$faker->phoneNumber()          // 電話番号
$faker->address()              // 住所
$fake->company()               // 会社名
$faker->numberBetween(1, 3)    // 範囲指定
$faker->unique()->safeEmail    // メールアドレス


randomNumber



'email' => $this->faker->unique()->safeEmail,
'email_verified_at' => now(),
'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
'remember_token' => Str::random(10),
```

_______________________________________________________________
## Fakerチートシート
https://qiita.com/tosite0345/items/1d47961947a6770053af

#### 公式ドキュメント（日本語）
https://faker.readthedocs.io/en/master/locales/ja_JP.html


### プロパティ

|  型                                |  戻り値の型     |  変数名                             |  日本語訳                   |  実例                                                                                                                                                               |
|:----------------------------------|:-----------|:---------------------------------|:------------------------|:------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|  property                         |  string    |  name                            |  名                      |  Dr. Nova Romaguera DVM                                                                                                                                           |
|  property                         |  string    |  firstName                       |  ファーストネーム               |  Ara                                                                                                                                                              |
|  property                         |  string    |  firstNameMale                   |  ファーストネーム（男性）           |  Sonny                                                                                                                                                            |
|  property                         |  string    |  firstNameFemale                 |  ファーストネーム（女性）           |  Cathryn                                                                                                                                                          |
|  property                         |  string    |  lastName                        |  苗字                     |  Carter                                                                                                                                                           |
|  property                         |  string    |  title                           |  敬称                     |  Miss                                                                                                                                                             |
|  property                         |  string    |  titleMale                       |  敬称（男性）                 |  Dr.                                                                                                                                                              |
|  property                         |  string    |  titleFemale                     |  敬称（女性）                 |  Dr.                                                                                                                                                              |
|  property                         |  string    |  citySuffix                      |  都市接頭辞                  |  port                                                                                                                                                             |
|  property                         |  string    |  streetSuffix                    |  ストリート接頭辞               |  Harbors                                                                                                                                                          |
|  property                         |  string    |  buildingNumber                  |  建物番号                   |  611                                                                                                                                                              |
|  property                         |  string    |  city                            |  都市名                    |  Maymietown                                                                                                                                                       |
|  property                         |  string    |  streetName                      |  ストリート名                 |  Tamara Island                                                                                                                                                    |
|  property                         |  string    |  streetAddress                   |  住所（県より下から？）            |  7302 Olson Terrace Suite 409                                                                                                                                     |
|  property                         |  string    |  postcode                        |  郵便番号                   |  84857                                                                                                                                                            |
|  property                         |  string    |  address                         |  住所（県から全て？）             |  284 Dicki Ports Suite 992 West Kevenport, HI 17690-8028                                                                                                          |
|  property                         |  string    |  country                         |  国                      |  Sierra Leone                                                                                                                                                     |
|  property                         |  float     |  latitude                        |  緯度                     |  57.091455                                                                                                                                                        |
|  property                         |  float     |  longitude                       |  経度                     |  95.512512                                                                                                                                                        |
|  property                         |  string    |  ean13                           |  EAN-13（バーコード）          |  4757842760420                                                                                                                                                    |
|  property                         |  string    |  ean8                            |  EAN-8                  |  24934060                                                                                                                                                         |
|  property                         |  string    |  isbn13                          |  ISBN-13（書籍コード）         |  9786957525803                                                                                                                                                    |
|  property                         |  string    |  isbn10                          |  ISBN-10                |  7953440733                                                                                                                                                       |
|  property                         |  string    |  phoneNumber                     |  電話番号                   |  +1-832-333-7325                                                                                                                                                  |
|  property                         |  string    |  company                         |  会社                     |  Johnston LLC                                                                                                                                                     |
|  property                         |  string    |  companySuffix                   |  会社接尾辞                  |  Ltd                                                                                                                                                              |
|  property                         |  string    |  jobTitle                        |  職名                     |  History Teacher                                                                                                                                                  |
|  property                         |  string    |  creditCardType                  |  クレジットカード種類             |  MasterCard                                                                                                                                                       |
|  property                         |  string    |  creditCardNumber                |  クレジットカード番号             |  4916146807378620                                                                                                                                                 |
|  property                         |  DateTime  |  creditCardExpirationDate        |  クレジットカード有効期限           |  "date": "2017-10-26 22:00:33.000000",  "timezone_type": 3,  "timezone": "Asia/Tokyo"                                                                                                                           |
|  property                         |  string    |  creditCardExpirationDateString  |  クレジットカード有効期限（日付文字列）    |  08/19                                                                                                                                                            |
|  property                         |  array     |  creditCardDetails               |  クレジットカード詳細             |  "type" => "Visa",  "number" => "4485071238445701", "expirationDate" => "10/17", "name" => "Conner Greenholt",                                                                                                                                            |
|  property                         |  string    |  bankAccountNumber               |  銀行口座番号                 |  15217633371                                                                                                                                                      |
|  property                         |  string    |  swiftBicNumber                  |  SWIFTコード（銀行コード）        |  KFMAOAVNOAJ                                                                                                                                                      |
|  property                         |  string    |  vat                             |  VAT（付加価値税？）            |  （エラー）                                                                                                                                                            |
|  property                         |  string    |  word                            |  ワード                    |  dolore                                                                                                                                                           |
|  property                         |  string    |  array                           |  words                  |  言葉                                                                                                                                                               |
|  property                         |  string    |  sentence                        |  文                      |  Et sapiente omnis beatae eligendi.                                                                                                                               |
|  property                         |  string    |  array                           |  sentences              |  文章                                                                                                                                                               |
|  property                         |  string    |  paragraph                       |  段落（単行）                 |  Aut occaecati aliquid est porro necessitatibus molestias. Inventore qui magnam accusamus quos aliquam molestiae provident nihil. Minus ut non laboriosam fugit.  |
|  property                         |  string    |  array                           |  paragraphs             |  段落（複数行）                                                                                                                                                          |
|  property                         |  string    |  text                            |  テキスト                   |  Rem illum et aut mollitia. Velit perspiciatis dolore vel sed et sequi reiciendis. Quibusdam libero debitis enim aut.                                             |
|  property                         |  string    |  email                           |  Eメール                   |  victor50@hotmail.com                                                                                                                                             |
|  property                         |  string    |  safeEmail                       |  安全な電子メール（存在しない）        |  mallory27@example.com                                                                                                                                            |
|  property                         |  string    |  freeEmail                       |  無料の電子メール（場合によっては存在する）  |  kaela.deckow@gmail.com                                                                                                                                           |
|  property                         |  string    |  companyEmail                    |  会社の電子メール               |  cswift@osinski.com                                                                                                                                               |
|  property                         |  string    |  freeEmailDomain                 |  無料の電子メールドメイン（存在する）     |  hotmail.com                                                                                                                                                      |
|  property                         |  string    |  safeEmailDomain                 |  安全な電子メールドメイン（存在しない）    |  example.org                                                                                                                                                      |
|  property                         |  string    |  userName                        |  ユーザー名                  |  raoul68                                                                                                                                                          |
|  property                         |  string    |  password                        |  パスワード                  |  PVqg5V!{/6MWHzg/FLe]                                                                                                                                             |
|  property                         |  string    |  domainName                      |  ドメイン名                  |  runolfsdottir.net                                                                                                                                                |
|  property                         |  string    |  domainWord                      |  ドメインワード                |  grady                                                                                                                                                            |
|  property                         |  string    |  tld                             |  トップレベルドメイン             |  com                                                                                                                                                              |
|  property                         |  string    |  url                             |  URL                    |  http://olson.info/                                                                                                                                               |
|  property                         |  string    |  slug                            |  スラグ                    |  possimus-ut-quia-consequatur-officia                                                                                                                             |
|  property                         |  string    |  ipv4                            |  IPv4                   |  105.81.125.129                                                                                                                                                   |
|  property                         |  string    |  ipv6                            |  IPv6                   |  ef5a:ef5c:a6c4:bc44:8433:b1b2:d265:b886                                                                                                                          |
|  property                         |  string    |  localIpv4                       |  ローカルなIPv4              |  10.55.156.47                                                                                                                                                     |
|  property                         |  string    |  macAddress                      |  Macアドレス                |  A6:95:18:97:0F:EE                                                                                                                                                |
|  property                         |  int       |  unixTime                        |  UNIX時間                 |  477897933                                                                                                                                                        |
|  property                         |  DateTime  |  dateTime                        |  日付時刻                   |  "date": "1977-01-12 18:33:31.000000", "timezone_type": 3, "timezone": "Asia/Tokyo"                                                                                                                             |
|  property                         |  DateTime  |  dateTimeAD                      |  日付時刻（西暦紀元）             |  "date: 1856-02-08 01:29:08.000000, "timezone_type": 3, "timezone": "Asia/Tokyo"                                                                                                                                |
|  property                         |  string    |  iso8601                         |  ISO8601                |  1971-04-30T10:19:35+0900                                                                                                                                         |
|  property                         |  DateTime  |  dateTimeThisCentury             |  日付時刻（今の世紀）             |  "date: 1944-03-07 04:07:04.000000, "timezone_type": 3, "timezone": "Asia/Tokyo"                                                                                                                                |
|  property                         |  DateTime  |  dateTimeThisDecade              |  日付時刻（直近１０年内）           |  "date: 2015-11-25 15:30:00.000000, "timezone_type": 3, "timezone": "Asia/Tokyo"                                                                                                                                |
|  property                         |  DateTime  |  dateTimeThisYear                |  日付時刻（今年）               |  "date: 2016-12-13 17:21:21.000000, "timezone_type": 3, "timezone": "Asia/Tokyo"                                                                                                                                |
|  property                         |  DateTime  |  dateTimeThisMonth               |  日付時刻（今月）               |  "date: 2017-09-25 10:40:14.000000, "timezone_type: 3, "timezone": "Asia/Tokyo"                                                                                                                                |
|  property                         |  string    |  amPm                            |  午前・午後                  |  pm                                                                                                                                                               |
|  property                         |  int       |  dayOfMonth                      |  日                      |  18                                                                                                                                                               |
|  property                         |  int       |  dayOfWeek                       |  曜日                     |  Saturday                                                                                                                                                         |
|  property                         |  int       |  month                           |  月                      |  11                                                                                                                                                               |
|  property                         |  string    |  monthName                       |  月名                     |  July                                                                                                                                                             |
|  property                         |  int       |  year                            |  年                      |  1981                                                                                                                                                             |
|  property                         |  int       |  century                         |  世紀                     |  III                                                                                                                                                              |
|  property                         |  string    |  timezone                        |  タイムゾーン                 |  America/Caracas                                                                                                                                                  |
|  property                         |  string    |  md5                             |  MD5                    |  a1726594f03a11892b5697b710fe23d8                                                                                                                                 |
|  property                         |  string    |  sha1                            |  SHA-1                  |  708259c55f1d4aabbaf4a142cea2ede36c142c7f                                                                                                                         |
|  property                         |  string    |  sha256                          |  SHA-256                |  1054fe8d2367cbbcfcc7d35c05a2fa497885bcf10c91785dcc1ecc1f25142f80                                                                                                 |
|  property                         |  string    |  locale                          |  場所                     |  hu_HU                                                                                                                                                            |
|  property                         |  string    |  countryCode                     |  国コード                   |  MX                                                                                                                                                               |
|  property                         |  string    |  countryISOAlpha3                |  国（ISO alpha-3基準？）      |  SAU                                                                                                                                                              |
|  property                         |  string    |  languageCode                    |  言語コード                  |  ng                                                                                                                                                               |
|  property                         |  string    |  currencyCode                    |  通貨コード                  |  ZWL                                                                                                                                                              |
|  property                         |  boolean   |  boolean                         |  ブール値                   |  true                                                                                                                                                             |
|  property                         |  int       |  randomDigit                     |  ランダムな桁                 |  8                                                                                                                                                                |
|  property                         |  int       |  randomDigitNotNull              |  ランダムな桁（Null以外）         |  2                                                                                                                                                                |
|  property                         |  string    |  randomLetter                    |  ランダム文字                 |  p                                                                                                                                                                |
|  property                         |  string    |  randomAscii                     |  ランダムアスキー               |  =                                                                                                                                                                |
|  property                         |  string    |  macProcessor                    |  MACプロセッサ               |  Intel                                                                                                                                                            |
|  property                         |  string    |  linuxProcessor                  |  LINUXプロセッサ             |  x86_64                                                                                                                                                           |
|  property                         |  string    |  userAgent                       |  ユーザーエージェント             |  Opera/9.52 (Windows NT 6.0; sl-SI) Presto/2.11.177 Version/10.00                                                                                                 |
|  property                         |  string    |  chrome                          |  Chrome                 |  Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/5330 (KHTML, like Gecko) Chrome/37.0.831.0 Mobile Safari/5330                                                        |
|  property                         |  string    |  firefox                         |  FireFox                |  Mozilla/5.0 (X11; Linux i686; rv:5.0) Gecko/20160719 Firefox/37.0                                                                                                |
|  property                         |  string    |  safari                          |  Safari                 |  Mozilla/5.0 (iPad; CPU OS 7_1_1 like Mac OS X; en-US) AppleWebKit/532.19.5 (KHTML, like Gecko) Version/4.0.5 Mobile/8B116 Safari/6532.19.5                       |
|  property                         |  string    |  opera                           |  Opera                  |  Opera/9.15 (X11; Linux i686; en-US) Presto/2.8.273 Version/12.00                                                                                                 |
|  property                         |  string    |  internetExplorer                |  InternetExplorer       |  Mozilla/5.0 (compatible; MSIE 5.0; Windows NT 4.0; Trident/5.1)                                                                                                  |
|  property                         |  string    |  windowsPlatformToken            |  Windowsプラットフォームトークン    |  Windows NT 5.01                                                                                                                                                  |
|  property                         |  string    |  macPlatformToken                |  MACプラットフォームトークン        |  Macintosh; U; Intel Mac OS X 10_7_8                                                                                                                              |
|  property                         |  string    |  linuxPlatformToken              |  LINUXプラットフォームトークン      |  X11; Linux x86_64                                                                                                                                                |
|  property                         |  string    |  uuid                            |  UUID                   |  da624486-709e-3720-81e4-f9dc3a302f99                                                                                                                             |
|  property                         |  string    |  mimeType                        |  MIMEタイプ                |  video/x-fli                                                                                                                                                      |
|  property                         |  string    |  fileExtension                   |  拡張子ファイル                |  ims                                                                                                                                                              |
|  property                         |  string    |  hexColor                        |  16進数カラーコード             |  #b17501                                                                                                                                                          |
|  property                         |  string    |  safeHexColor                    |  セーフカラー16進数コード          |  #00dd77                                                                                                                                                          |
|  property                         |  string    |  rgbColor                        |  RGBカラー                 |  205244170                                                                                                                                                        |
|  property                         |  array     |  rgbColorAsArray                 |  RGBカラー（配列）             |  0 => 88, 1 => 114, 2 => 163,                                                                                                                                                        |
|  property                         |  string    |  rgbCssColor                     |  RGB（CSS）               |  rgb(102,225,202)                                                                                                                                                 |
|  property                         |  string    |  safeColorName                   |  セーフカラー名                |  white                                                                                                                                                            |
|  property                         |  string    |  colorName                       |  カラー名                   |  AliceBlue                                                                                                                                                        |


### メソッド

|  型                            |  戻り値の型                     |  メソッド名                |  引数                               |  翻訳          |
|:------------------------------|:---------------------------|:----------------------|:----------------------------------|:-------------|
|  method                       |  string                    |  name                 |  string $gender = null            |  名前          |
|  method                       |  string                    |  firstName            |  string $gender = null            |  ファーストネーム    |
|  method                       |  string                    |  title                |  string $gender = null            |  敬称          |
|  method                       |  string                    |  creditCardNumber     |  $type = null, $formatted = false,                   |
|            |
|  $separator = '-'             |  クレジットカード番号                |
|  method                       |  string                    |  iban                 |  $countryCode = null,             |
|  $prefix = '',                |
|  $length = null               |  IBANコード（インターネットバンキングコード）  |
|  method                       |  string or array           |  words                |  $nb = 3,                         |
|  $asText = false              |  言葉                        |
|  method                       |  string                    |  sentence             |  $nbWords = 6,                    |
|  $variableNbWords = true      |  文                         |
|  method                       |  string or array           |  sentences            |  $nb = 3,                         |
|  $asText = false              |  文章                        |
|  method                       |  string                    |  paragraph            |  $nbSentences = 3,                |
|  $variableNbSentences = true  |  段落（単行）                    |
|  method                       |  string or array           |  paragraphs           |  $nb = 3,                         |
|  $asText = false              |  段落（複数行）                   |
|  method                       |  string                    |  text                 |  $maxNbChars = 200                |  テキスト        |
|  method                       |  string                    |  realText             |  $maxNbChars = 200,               |
|  $indexSize = 2               |  リアルテキスト                   |
|  method                       |  string                    |  password             |  $minLength = 6,                  |
|  $maxLength = 20              |  パースワード                    |
|  method                       |  string                    |  slug                 |  $nbWords = 6,                    |
|  $variableNbWords = true      |  スラグ                       |
|  method                       |  string                    |  amPm                 |  $max = 'now'                     |  午前午後        |
|  method                       |  string                    |  date                 |  $format = 'Y-m-d',               |
|  $max = 'now'                 |  日付                        |
|  method                       |  string                    |  dayOfMonth           |  $max = 'now'                     |  日           |
|  method                       |  string                    |  dayOfWeek            |  $max = 'now'                     |  曜日          |
|  method                       |  string                    |  iso8601              |  $max = 'now'                     |  ISO8601     |
|  method                       |  string                    |  month                |  $max = 'now'                     |  月           |
|  method                       |  string                    |  monthName            |  $max = 'now'                     |  月名          |
|  method                       |  string                    |  time                 |  $format = 'H:i:s',               |
|  $max = 'now'                 |  時間                        |
|  method                       |  string                    |  unixTime             |  $max = 'now'                     |  UNIX時間      |
|  method                       |  string                    |  year                 |  $max = 'now'                     |  年           |
|  method                       |  DateTime                  |  dateTime             |  $max = 'now',                    |
|  $timezone = null             |  日付時刻                      |
|  method                       |  DateTime                  |  dateTimeAd           |  $max = 'now',                    |
|  $timezone = null             |  日付時刻（西暦紀元）                |
|  method                       |  DateTime                  |  dateTimeBetween      |  $startDate = '-30 years',        |
|  $endDate = 'now'             |  日付時刻（指定した範囲）              |
|  method                       |  DateTime                  |  dateTimeInInterval   |  $date = '-30 years',             |
|  $interval = '+5 days',       |
|  $timezone = null             |  日付間隔                      |
|  method                       |  DateTime                  |  dateTimeThisCentury  |  $max = 'now',                    |
|  $timezone = null             |  日付時刻（今の世紀）                |
|  method                       |  DateTime                  |  dateTimeThisDecade   |  $max = 'now',                    |
|  $timezone = null             |  日付時刻（直近１０年内）              |
|  method                       |  DateTime                  |  dateTimeThisYear     |  $max = 'now',                    |
|  $timezone = null             |  日付時刻（今年）                  |
|  method                       |  DateTime                  |  dateTimeThisMonth    |  $max = 'now',                    |
|  $timezone = null             |  日付時刻（今月）                  |
|  method                       |  boolean                   |  boolean              |  $chanceOfGettingTrue = 50        |  ブール値        |
|  method                       |  int                       |  randomNumber         |  $nbDigits = null,                |
|  $strict = false              |  乱数                        |
|  method                       |  int or string or null     |  randomKey            |  array $array = array             |  ランダムキー      |
|  method                       |  int                       |  numberBetween        |  $min = 0,                        |
|  $max = 2147483647            |  数字（指定した範囲）                |
|  method                       |  float                     |  randomFloat          |  $nbMaxDecimals = null,           |
|  $min = 0,                    |
|  $max = null                  |  ランダムフロート                  |
|  method                       |  mixed                     |  randomElement        |  array $array = ['a', 'b', 'c']   |  ランダム要素（単行）  |
|  method                       |  array                     |  randomElements       |  array $array = ['a', 'b', 'c'],  |
|  $count = 1,                  |
|  $allowDuplicates = false     |  ランダム要素（複数行）               |
|  method                       |  array or string           |  shuffle              |  $arg = ''                        |  シャッフル       |
|  method                       |  array                     |  shuffleArray         |  array $array = []                |  シャッフル配列     |
|  method                       |  string                    |  shuffleString        |  $string = '',                    |
|  $encoding = 'UTF-8'          |  シャッフル文字列                  |
|  method                       |  string                    |  numerify             |  $string = '###'                  |  数える         |
|  method                       |  string                    |  lexify               |  $string = '????'                 |  レキシシック      |
|  method                       |  string                    |  bothify              |  $string = '## ??'                |  両立          |
|  method                       |  string                    |  asciify              |  $string = '****'                 |  上昇する        |
|  method                       |  string                    |  regexify             |  $regex = ''                      |  再正規化する      |
|  method                       |  string                    |  toLower              |  $string = ''                     |  小文字へ        |
|  method                       |  string                    |  toUpper              |  $string = ''                     |  大文字へ        |
|  method                       |  Generator                 |  optional             |  $weight = 0.5,                   |
|  $default = null              |  任意の                       |
|  method                       |  Generator                 |  unique               |  $reset = false,                  |
|  $maxRetries = 10000          |  ユニークな                     |
|  method                       |  Generator                 |  valid                |  $validator = null,               |
|  $maxRetries = 10000          |  有効な                       |
|  method                       |  integer                   |  biasedNumberBetween  |  $min = 0,                        |
|  $max = 100,                  |
|  $function = 'sqrt'           |  偏った番号                     |
|  method                       |  string                    |  file                 |  $sourceDirectory = '/tmp',       |
|  $targetDirectory = '/tmp',   |
|  $fullPath = true             |  ファイル                      |
|  method                       |  string                    |  imageUrl             |  $width = 640,                    |
|  $height = 480,               |
|  $category = null,            |
|  $randomize = true,           |
|  $word = null,                |
|  $gray = false                |  画像URL                     |
|  method                       |  string                    |  image                |  $dir = null,                     |
|  $width = 640,                |
|  $height = 480,               |
|  $category = null,            |
|  $fullPath = true,            |
|  $randomize = true,           |
|  $word = null                 |  画像                        |
|  method                       |  string                    |  randomHtml           |  $maxDepth = 4,                   |
|  $maxWidth = 4                |  ランダムHTML                  |
