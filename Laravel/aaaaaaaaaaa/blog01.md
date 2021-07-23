
## 補足
こんなのがありました。  

[【Laravel】 Cron タスクスケジューラの onOneServer() と withoutOverlapping() の違い](https://qiita.com/mpyw/items/15d14d920250a3b9eb5a)  

> withoutOverlapping() は onOneServer() と併用して，初めて意味のある選択肢になります。

えええ！！！　そうなの！？  

と思いきや、  
「重複起動しないように withoutOverlapping() を付けるんだろうけど、onOneServer() も付けないと他のサーバで重複実行される可能性があるから、併用しないと片手落ちになっちゃうよ。」  
っていう意味か。  

初見、  
「withoutOverlapping() は、onOneServer() と一緒に使わないと意味をなさない（重複起動を防ぐ、という機能を満たさない）」  
という意味かと思ってしまった。  
（もちろん、そんな事は無い事は上記で検証済み）  

という事で、バッチを実行するサーバが１台のみの場合、「withoutOverlapping()」だけでも、ジョブの重複起動を防止できます。  

まぁ、そのうちサーバが増えた時に「onOneServer()」を追加するとか面倒なので、無条件で「onOneServer()」をくっつけといた方がいんじゃないかと思います。  

理由としては、サーバ１台で動かす事を前提とした場合でも、特に何の問題も無いと確信が持てたからです。  



https://kaki-note-02.netlify.app/2021/07/24/
