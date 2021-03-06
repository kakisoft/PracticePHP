# Zend Framework

## URL
```
https://kakisoftex.co.jp/Login/
https://kakisoftex.co.jp/Manual/
https://kakisoftex.co.jp/Partner/
```

## ビュー
```
application/modules/default/views/scripts/
application/modules/default/views/scripts/Login/
application/modules/default/views/scripts/Manual/
application/modules/default/views/scripts/Partner/
```

## コントローラ
```
application/modules/default/controllers/
application/modules/default/controllers/LoginController.php
application/modules/default/controllers/ManualController.php
application/modules/default/controllers/PartnerController.php

```


## コントローラ -> アクション
```
https://kakisoftex.co.jp/partner/registration/

⇒
-----------------------------------------
application/modules/default/controllers/PartnerController.php

    public function registrationAction()

       ※クエリストリングがある場合のみ実行？
-----------------------------------------
application/modules/default/views/scripts/partner/registration.phtml
-----------------------------------------



デフォルトは多分、index.html とか index.phtml

無い場合はリダイレクト。（多分。設定による？）
```


## アクション先のメソッド
```php

https://kakisoftex.co.jp/order/form/

## application/modules/default/controllers/OrderController.php

 -> public function formAction()
```

## controllers 配下のフォルダ
#### ファイル例
```
application\controllers\test\ChartScoreController.php
```
#### アクセス例
```
http://sample01.com/test_ChartScore/index
```
フォルダ階層は、「_」で繋げる。     


## アクションコントローラの呼出し順序
http://hensa40.cutegirl.jp/archives/5904

 1. init メソッド
 2. preDispatch メソッド
 3. アクションメソッド本体
 4. postDispatch メソッド



 ## フロントコントローラ
https://framework.zend.com/manual/1.12/ja/zend.controller.front.html
```
getInstance() は、フロントコントローラのインスタンスを取得します。 
フロントコントローラはシングルトンパターンを実装しているので、 フロントコントローラのインスタンスを作成する唯一の方法はこのメソッドをコールすることとなります。
```

application/modules/default/models/  
の階層で使われていたりする。
フロント（Viewと同じ意味？）側で取得した値を、model側で参照する場合とかに使用する？



## アクションコントローラ
```
https://kakiiiii.dev/manual/
⇒ 「ManualController.php」を見る
　　public function indexAction()
　　　⇒ 「views/scripts/manual/index.phtml」を見る



https://kakiiiii.dev/manual/hp/web-server/
⇒ 「views/scripts/manual/hp/web-server.phtml」を見る
```


## アクションの取得について
```php
$currentAction = $this->view->currentAction = $this->getRequest()->getActionName();

echo "<br>=======================<br>";
var_dump($currentAction);
var_dump($this->view->currentAction);
var_dump($this->getRequest()->getActionName());
echo "<br>=======================<br>";

https://kakiiiii.dev/order/form/
/application/modules/default/controllers/OrderController.php:59:
string 'form' (length=4)



https://kakiiiii.dev/order/customer/
/application/modules/default/controllers/OrderController.php:59:
string 'customer' (length=8)
```


## アクションにおけるリクエストパラメータの取得
```php
https://lolipop.pbdev/order/partnership/camid/aaaaa/
https://lolipop.pbdev/order/partnership/hogep/aaaakkkkkk/


echo "getUserParam - camid【" . $this->getRequest()->getUserParam('camid') . "】";
echo "getUserParam - hogep【" . $this->getRequest()->getUserParam('hogep') . "】";


getUserParam - camid【aaaaa】
getUserParam - hogep【aaaakkkkkk】
```

## アクションにおけるリクエストパラメータの取得２
```php
$request = $this->getRequest();

$a1 = $request->getPost('param1');
$a2 = $_POST['param1'];
$a3 = (int)$request->getParam( 'param1', 1 );
$a4 = $request->getParam( 'param1');
```


## アクションにおけるリクエストパラメータの取得（全部）
```php
		// パラメータ取得
		$request = $this->getRequest();
        $requestParams = $request->getParams();
```



## getXXXName
```php
// $this->request = $this->getRequest();
$this->request->getControllerName()
$this->request->getActionName()
```


## View ： 普通に使う場合
```
http://sampleProject.com/contract/regist

→ application\views\templates\contract\regist.tpl
```

## View ： イレギュラーパターン（フレームワークのルールに従わない場合） 
```php
$this->render( 'other_template' );

→ application\views\templates\contract\other_template.tpl
```

## Viewに、コントローラから受け取った値を設定
```php
$this->view->assign('param1', $param1);
$this->view->assign('array1', $array1);
$this->view->assign('app_path', APPLICATION_PATH);
```

## View に別のテンプレート（tpl, template）を使用する
```php
<h1>
{{include file="$app_path/views/templates/projectlist/header_content.tpl"}}
<h2>
```


## getResponse
```php
class CommonControllerAction extends Zend_Controller_Action
{
    puclic function mySample01
    {
        /**
         * XXXドキュメント生成
         * */
        $builder->output($path1, PdfConstructionIndicationBuilder::OUTPUT_MODE_LOCALFILE);
        if (isset($_POST['offer_id_2'])) {
            $this->_helper->viewRenderer->setNoRender();
            $dlFilePath = $path1;
            $dlFileName = $path2;

            // ヘッダの設定
            $this->getResponse()->setHeader('Content-type', 'application/octet-stream');
            $this->getResponse()->setHeader('Content-Disposition', 'attachment; filename=' . $dlFileName);
            $this->getResponse()->setHeader('Content-length', filesize($dlFilePath));

            // ヘッダの送信
            $this->getResponse()->sendHeaders();
            $fhandle = fopen($dlFilePath, 'r');

            while (!feof($fhandle)) {

                // body にセットし、出力する
                $this->getResponse()->setBody(fread($fhandle, 8192));
                $this->getResponse()->outputBody();
            }
            fclose($fhandle);
            exit;
        }
    }

}
```

_____________________________________________________________________________________
## application/modules/default/controllers/OrderController.php
Controller側にて、Customer View で使用する値をセット
```php
    $this->view->partnership = new Partnership($this->_sess['guest']->partnership_cd);
```


## application/modules/default/views/scripts/order/customer.phtml
こんな感じで使う。

```php
    <?php
        /* 何かのフォーム */
        elseif ($this->zerohighschool) :
            $this->renderModules('order-form-special01');
    ?>

    <?php
        /* 提携先 */
        elseif ( isset($this->partnership) && $this->partnership->isPartnership() ) :
            $this->renderModules('order-form-partnership');
    ?>
```
_____________________________________________________________________________________
## renderModules

```phtml
<?php echo $this->renderModules('order-infomation'); ?>
```
application/modules/default/views/modules/parts/order-infomation.phtml  
のファイル

_____________________________________________________________________________________

## Zend_Layout 
https://framework.zend.com/manual/1.10/ja/zend.layout.quickstart.html
```php
    // レイアウトヘルパーで使用するコンテンツのキーを取得します
    echo $this->layout()->content;
```
```php
public function bazAction()
{
    // このアクションでは別のレイアウトスクリプトを使用します
    $this->_helper->layout->setLayout('foobaz');
};


「 foobaz 」というファイル名がある。
```


_____________________________________________________________________________________
## HTTP パラメータ取得
```php
$referer = $this->getRequest()->getHeader('referer');
```


## ビュー(テンプレート)の基本 - [Zend Framework/PHP] ぺんたん info
http://pentan.info/php/zend_fw/view.html



_____________________________________________________________________________________
## Zend_Session_Namespace について
https://www.rasukarusan.com/entry/2018/10/08/213251
```php

class Hoge {
    protected $name;

    public function setProperty() {
        $this->name = 'TANAKA';
    }
}

$session = new Zend_Session_Namespace('hoge')
$session->hoge = new Hoge();
```
この時、$session->hoge->setProperty(); としてやればクラスHogeのメソッドであるsetProperty()が実行できる。  
実行すると$session->hogeの$nameに'TANAKA'がセットされる。 この状態で
```php
echo $session->hoge->name;
```
とすれば'TANAKA'と表示される。


_____________________________________________________________________________________
## エスケープ
https://framework.zend.com/manual/1.12/ja/zend.view.introduction.html
```php
$this->escape($val['author'])
```


_____________________________________________________________________________________
## Zend_Db::factory
https://framework.zend.com/manual/1.12/ja/zend.db.adapter.html
```php
// 自動的に Zend_Db_Adapter_Pdo_Mysql クラスを読み込み、
// そのインスタンスを作成します
$db = Zend_Db::factory('Pdo_Mysql', array(
    'host'     => '127.0.0.1',
    'username' => 'webuser',
    'password' => 'xxxxxxxx',
    'dbname'   => 'test'
));
```

_____________________________________________________________________________________
## バリデーション
```php
$validator['len'] = new Zend_Validate_StringLength(3, 16);
$validator['regex1'] = new Zend_Validate_Regex($regex1);
$validator['regex2'] = new Zend_Validate_Regex($regex2);
```

_____________________________________________________________________________________
## コンフィグ読み込み
```php
$this->_config['regex'] = new Zend_Config_Ini($this->_front->getParam('regexIni'));
```

_____________________________________________________________________________________
## リダイレクト
```php
//こっちでは上手く行かず。
$url = 'http://www.example.com/';
header('Location: ' . $url, true, 301);


//こっち
$this->_redirect($url);

//相対パスで指定
$this->_redirect('/login/');
```
_____________________________________________________________________________________
## パラメータ取得（GET、POST など）
```php
$value = array(
              "unique_id" => $this->getRequest()->getParam("unique_id")
            , "param1" => $this->getRequest()->getParam("param1")
            , "text" => $this->getRequest()->getParam("text")

        );

//もちろん、といった感じで取る事も可。
$value = $_POST['unique_id'];
```

_____________________________________________________________________________________
## パラメータセット
```php
$this->getRequest()->setParam("category", "marketing");
```

_____________________________________________________________________________________
## アクションのみ（View不要の処理）  Actionのみ
テンプレート tpl 不要の場合   
（対応するテンプレートが無いと、エラーが発生する）  
```php
//Smarty error: unable to read resource
//　　「setNoRender」が必要。

    /**
     * 特殊エリアの情報を返却
     * */
    public function ajaxgetspecialareaAction() {

        // TOPの非同期で沢山のリクエストが走る＋この動作が重い為、セッションをアンロック
        session_write_close();

        // このアクションでのみ自動レンダリングを無効にします
        //  ＜※重要※＞
        $this->_helper->viewRenderer->setNoRender();

        //パラメータを設定
        $company_id = $this->userData["company_id"];
        $company_office_id = $this->userData["company_office_id"];

        //データ取得取得
        $data = $this->model->News->getUncheckedSpecialAreaInfo($company_id, $company_office_id);

        echo Zend_Json::encode($data);
    }

//返却は json形式でなければいけない？
```

_____________________________________________________________________________________
## Actionメソッドは、全て小文字にする必要があるみたい。  
一応、CamelCaseで記述可能にする設定もあるっぽい。
https://framework.zend.com/manual/1.5/ja/zend.controller.migration.html

_____________________________________________________________________________________
## 定義した値を smartyで使用
```php
nanikanoAction(){
    $CONST_PARAMS['NANKANO_ATAI_1'] = AreaModel::NANKANO_ATAI_1;
    $CONST_PARAMS['NANKANO_ATAI_2'] = AreaModel::NANKANO_ATAI_2;
    $CONST_PARAMS['NANKANO_ATAI_3'] = AreaModel::NANKANO_ATAI_3;
    
    $this->_smarty->assign('CONST_PARAMS', $CONST_PARAMS);

}
```

```js
<script type='text/javascript'>
        switch (String($(this).val())){
            case "{{$CONST_PARAMS.NANKANO_ATAI_1}}":
                console.log({{$CONST_PARAMS.NANKANO_ATAI_1}});
                break;

            case "{{$CONST_PARAMS.NANKANO_ATAI_2}}":
                console.log({{$CONST_PARAMS.NANKANO_ATAI_2}});
                break;

            case "{{$CONST_PARAMS.NANKANO_ATAI_3}}":
                console.log({{$CONST_PARAMS.NANKANO_ATAI_3}});
                break;

            default:
                console.log("default")
                break;

        }
</script>
```

_____________________________________________________________________________________
## コントローラクラスをインスタンス化する
```php
require_once(dirname(__FILE__) . "/IndivisualReportController.php");

$controllerInstance = new ReportMakerController($this->getRequest(), $this->getResponse());
$controllerInstance->fileUploadAction();
```
引数が必要。

#### 参考
library\Zend\Controller\Action.php
```php
public function __construct(
                                  Zend_Controller_Request_Abstract $request
                                , Zend_Controller_Response_Abstract $response
                                , array $invokeArgs = array()
                           )
```

_____________________________________________________________________________________
## URL とアクションメソッドの関係
```
url   : '/common/ajax-set-session-other-site'
```

```php
public function ajaxSetSessionOtherSiteAction() {
```
こんな感じで、「-」は無視される。  
（設定で変更できるみたい。）  

_____________________________________________________________________________________
