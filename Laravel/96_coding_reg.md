# PHP

## コーディング規約
PSR-2 に準拠します
http://www.infiniteloop.co.jp/docs/psr/psr-2-coding-style-guide.html

VSCode のプラグインにて、自動整形するようにしています。設定方法は以下を参照。
https://bwave.backlog.com/wiki/BBP/%E6%88%90%E6%9E%9C%E7%89%A9%2F%E9%96%8B%E7%99%BA%2F%E9%96%8B%E7%99%BA%E3%83%84%E3%83%BC%E3%83%AB


## その他コーディング規約

 - goto文は実行順序を曖昧にする為、使用禁止とする
 - マジックナンバーは禁止とする。（const で定数化する。また、public static 変数を、定数として使わないものとする。）
 - 定数は全て大文字のスネークケースとする。(例:FOO_CONST_VALUE)
 - 改行コードを結合する場合は、PHP_EOL定数を用いる。(例:$bar = 'a'.PHP_EOL)
 - true, false, null, self 等の予約語は、小文字を使用する。
 - クラス名は全てアッパーキャメルケースとする。(例:UpperCamelCase)
 - クラスメソッド及び関数名はローワーキャメルケースとする。(例:lowerCamelCase)
 - 特別な理由が無い限り、スネークケースではなく、ローワーキャメルケースを使用する。(例:$lowerCamelCaseValue)

（参考情報）
うまくメソッド名を付けるための参考情報  
https://qiita.com/KeithYokoma/items/2193cf79ba76563e3db6

うまくクラス名を付けるための参考情報  
https://qiita.com/KeithYokoma/items/ee21fec6a3ebb5d1e9a8

変数名・メソッド名を考えるときに便利なサービス  
https://codic.jp/

______________________________________________________________________________________________________
# Laravel

## レスポンスクラス
レスポンスクラスには、「 Illuminate\Http\Response 」を使用し、
「 Symfony\Component\HttpFoundation\Response 」は使用しない。


## HTTPステータスコードの返却
HTTP ステータスコードを返却する場合、「 200 」等のハードコーディングをせず、
「 Illuminate\Http\Response 」の定数を使用する。

（例）
Response::HTTP_OK


## Request の階層を設ける
rules や messages は、コントローラに書かず、Request階層に記述するものとする  
（php artisan make:request xxxRequest といったコマンドでリクエストクラスを生成し、  
　コントローラ側は Request $request ではなく、xxxRequest $request と、拡張クラスを使用する。）  

## app/Models  階層に配置するファイルは、モデルのみとする
extends Model のクラスのみを格納する。  
ユーティリティ等の処理を、この層に記述しない。  
新規Modelの追加時は「App\Traits\AuthorObservable」というTraitをuseする記述を追記する。  

## 共通処理
共通処理を書く場所は、以下の階層とする  
　ユーティリティ：　app/Facades　（どこからでもコールできる static な処理。メール送信、プッシュ通知等）  
　トレイト：　app/Traits　（継承関係が無いクラスにて、共通のメソッドを追加したい時）  

## モデル/コントローラの階層
リポジトリパターンを採用し、サービス層とリポジトリ層を設ける。  
「コントローラ→サービス→リポジトリ→モデル」  
の流れで操作する。  

## Controllers
 **コントローラ名は、「単数形 + "Controller"」とし、パスカルケース（先頭大文字）にする。（Good：ArticleController　　Bad： %%ArticlesController%% ）**  
１つのファイルには１つのクラスのみを記述し、ファイル名とクラス名は一致させる。  
ビジネスロジックの記述を禁止とする。  
Model の直接操作は禁止とする。  
基本的には Service をコールし、ロジックを書くことは避ける。  


## Services
**サービス名の末尾は、 "Service" とする。（Good：SomeFileUploadService）**  
１つのファイルには１つのクラスのみを記述し、ファイル名とクラス名は一致させる。  
ビジネスロジックを記述する。  
主にコントローラからコールされる。  
Model の直接操作は禁止とする。  
Model を操作する時は、この層から Repository を経由する。  
サービスからサービスをコールする場合、処理内容を、リポジトリ・ユーティリティ・トレイトといった場所に移譲できないかを検討し、  
可能な限りサービスからサービスへのコールは避ける。  

## Repositories
**リポジトリ名は、「対応するモデル名 + "Repository"」とする。（Good：AlbumRepository）**  
１つのファイルには１つのクラスのみを記述し、ファイル名とクラス名は一致させる。  
モデルを操作する時に使用し、モデルと一対一となる  

## Models
**モデル名は単数名とし、パスカルケース（先頭大文字）にする。（Good：User　Bad： %%Users%% ）**  
１つのファイルには１つのクラスのみを記述し、ファイル名とクラス名は一致させる。  
hasMany、belongsTo といったリレーションルールがあれば、記述する。  

## テストコードの階層
tests 階層に、Feature と Unit を作成。  
単体テストであれば Unit に階層を切って保存、  
機能単位でのテストであれば、Feature に階層を切って保存する。  

（例）
```
 └─tests
    ├─Feature
    │  └─SomeFuturTest.php
    │
    └─Unit
       ├─Http
       ├─Jobs
       ├─Services
       └─Models
           ├─Mocks
           │   └─UserMock.php
           ├─UserTest.php
```

## 備考
その他、迷った箇所があれば、基本スタンスは可能な限り「 laravel-best-practices 」に沿うものとする。
* [[Laravelベストプラクティス:https://github.com/alexeymezenin/laravel-best-practices/blob/master/japanese.md]]


## URL設計
[82_URL_design.md](82_URL_design.md)


## ミドルウェア
名称はドットケースとする。  
また、特別な理由が無い限り、クラス名とミドルウェア名は一致させる。（クラスはアッパーキャメルで記述し、ミドルウェア名はドットケースとする）  

