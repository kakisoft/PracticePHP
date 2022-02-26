■ PHP コーディング規約設定

エディタ ： VSCode
プラグイン： phpfmt - PHP formatter


【 １ 】
phpfmt - PHP formatter
で検索し、インストール。
https://marketplace.visualstudio.com/items?itemName=kokororin.vscode-phpfmt


【 ２ 】
Ctrl + Shift + p -> 
で「settings」と入力し、『Preferences: Open Settings(Json)』を選択。
（ settings.json を開く）


【 ３ 】









settings.json を、以下のように編集。

===========================
{
    "[php]": {
        "editor.defaultFormatter": "kokororin.vscode-phpfmt"
    },
    "editor.formatOnSave": true
}



















===========================


【 ４ 】
php ファイルを保存すると、自動整形される。

settings.json にて、
"editor.formatOnSave": false
と設定すると、保存時に自動整形をしない。

その場合、
Ctrl + Shift + f
にて、整形可。
















