## マジックナンバーは禁止とする
マジックナンバーを使用せず、const で定数化する。  
また、public static 変数を、定数として使わないものとする。  

______________________________________________________________________________________________________
# Laravel

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

