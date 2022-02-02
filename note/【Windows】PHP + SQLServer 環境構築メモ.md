# 【Windows】PHP + SQLServer 環境構築メモ

________________________________________________________________________________________
# 前提
あらかじめ、ローカルのWindowsマシンンに SQL Server Management Studio (SSMS)をインストール。  
これが無い場合、DBアクセス時にエラーが発生する（PHPのライブラリによる？）。  

________________________________________________________________________________________
# PHP

## CGI版 ダウンロード
PHPのダウンロードサイト。（Windows）  
[php download](https://windows.php.net/downloads/releases/archives/)  

php-5.3.29-nts-Win32-VC9-x86.zip  
とか。  

## PHP 配置
任意の場所。  
```
C:\Program Files\php
```
とか。  

バイナリ設置後、【php.ini】 を設置パス配下に格納する。  

## php.ini 設置
C:\Program Files\php\php-5.3.29-nts-Win32-VC9-x86  
に  
php.ini  
を配置。  



## Session Save Path の 設定
IISがセッションを書き込む場所。権限の干渉を受けない場所であれば、どこでもいい。  
```
C:\IISLog\session
```
とした。


### SqlServer Driver 導入
dll ファイルの配置  

例の通りだと、ここ。  
C:\Program Files\php\php-5.3.29-nts-Win32-VC9-x86\ext  

________________________________________________________________________________________
# IIS

## IIS のインストール
コンパネ→プログラムと機能 → Windowsの有効化または無効化  

## hostsファイル編集
```
C:\Windows\System32\drivers\etc  
```

## IIS サイトの追加
サイト（右クリック）→ Webサイトの追加  

```
- 入力値メモ  
  - サイト名：kakiweb01
  - 物理パス：アプリケーションパス[C:\inetpub\wwwroot\kakiweb014]   （ここにソースをクローンしていいかも）
  - ホスト名：kk.kakiweb01.local.com
```

## アクセス権限の設定
C:\inetpub\wwwroot 以下のフォルダのアクセス権を、フルコントロールにする。  


## IIS ハンドラーマッピング
＜IIS＞  
```
ハンドラーマッピング
 → モジュールマップの追加（右の「操作」ツリー）

要求パス： *.php
モジュール： FastCgiModule
実行可能ファイル： （ファイルの種類を「*.exe」に変更）  "C:\Program Files\php\php-5.3.29-nts-Win32-VC9-x86\php-cgi.exe"
名前： PHP 5.3.29 FastCGI
```


## ディレクトリ参照設定
＜IIS＞  
ディレクトリの参照 → 有効にする


## 規定ファイル設定
＜IIS＞  
既定のドキュメント → 追加 → index.php


## ReWriteModule 導入

下記パスからRewrite Module 2.0 のexe をダウンロード後、実行して正常終了すれば完了。  
[MicrosoftURLRewriteModule2.0forIIS 7(x64)](https://www.microsoft.com/en-us/download/confirmation.aspx?id=47337)  


## ReWriteModule : URL Rewrite 設定

##### C:\inetpub\wwwroot\MyApp01\settings\local\web.config
コピー
```xml
    <rewrite>
         <rules>
             <rule name="Imported Rule 1" stopProcessing="true">
                 <match url="^.*$" />
                 <conditions logicalGrouping="MatchAny">
                     <add input="{REQUEST_FILENAME}" matchType="IsFile" pattern="" ignoreCase="false" />
                     <add input="{REQUEST_FILENAME}" matchType="IsDirectory" pattern="" ignoreCase="false" />
                 </conditions>
                 <action type="None" />
             </rule>
             <rule name="Imported Rule 2" stopProcessing="true">
                 <match url="^.*$" />
                 <action type="Rewrite" url="index.php" />
             </rule>
         </rules>
    </rewrite>
```

##### C:\inetpub\wwwroot\MyApp01\web.config
ペースト先。コピー後は、こんな感じ？ 
```xml
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
    <system.webServer>
        <defaultDocument>
            <files>
                <add value="index.php" />
            </files>
        </defaultDocument>
        <handlers>
            <add name="PHP 5.3.29 FastCGI" path="*.php" verb="*" modules="FastCgiModule" scriptProcessor="C:\Program Files\php\php-5.3.29-nts-Win32-VC9-x86\php-cgi.exe" resourceType="File" />
        </handlers>
        <directoryBrowse enabled="true" />
        <rewrite>
             <rules>
                 <rule name="Imported Rule 1" stopProcessing="true">
                     <match url="^.*$" />
                     <conditions logicalGrouping="MatchAny">
                         <add input="{REQUEST_FILENAME}" matchType="IsFile" pattern="" ignoreCase="false" />
                         <add input="{REQUEST_FILENAME}" matchType="IsDirectory" pattern="" ignoreCase="false" />
                     </conditions>
                     <action type="None" />
                 </rule>
                 <rule name="Imported Rule 2" stopProcessing="true">
                     <match url="^.*$" />
                     <action type="Rewrite" url="index.php" />
                 </rule>
             </rules>
        </rewrite>
    </system.webServer>
</configuration>
```


## app.ini 設定

##### パス（例）
C:\inetpub\wwwroot\MyApp01\application\config
app.ini

________________________________________________________________________________________





________________________________________________________________________________________
________________________________________________________________________________________
________________________________________________________________________________________
# IIS 
version 6.2


## hosts
```
C:\Windows\System32\drivers\etc
hosts
```

## バインド設定
（WindowsのIISで単一IPアドレスのサーバーに複数のWebサイトを設置・運用）  
　  
サイト→下層の何か→右メニューの「バインド」→追加だったり編集だったり  

________________________________________________________________________________________
________________________________________________________________________________________
________________________________________________________________________________________

