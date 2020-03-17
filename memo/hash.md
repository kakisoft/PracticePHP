## 安全なパスワードハッシュ
https://www.php.net/manual/ja/faq.passwords.php  


## Salt と HMAC の違い
https://qiita.com/y_yoda/items/d586252b740c0c87f932  


#### Salt (ソルト)
パスワードを暗号化する際に付与されるデータのこと  
例えばメールアドレスとパスワードでアカウント登録を要求されるようなサービスにおいて、メールアドレスをSaltに含め、パスワードをハッシュ化して保存するといった使い方をします。  

Saltは秘密であることを重要視していないが  

 * ユーザーごとに異なるSaltであること (漏洩時のリスクを最小限にする為）
 * ある程度の長さを確保すること (推測されにくくする為)

が推奨される。  

#### HMAC (Hash-based Message Authentication Code) 
鍵(メッセージ認証符号のことです)とデータとハッシュ関数を元に計算されたハッシュ値を持つ。  
鍵は秘密である必要があり、可能な限り高速となるように設計されている。  



