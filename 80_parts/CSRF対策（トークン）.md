```php

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "Invalid Token!";
      exit;
    }
  }

=========================================================

  public function __construct() {
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
    $this->_errors = new \stdClass();
    $this->_values = new \stdClass();
  }

=========================================================

      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">

=========================================================
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓

	public static function genToken() {
		return uniqid(mt_rand() . '_', true);
	}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
CONST MYTOKEN = "_my_token_";

			if(count($_POST) <= 0){
          $token = MyUtils::genToken();
          session_start();
          $_SESSION[self::MYTOKEN] = $token;

          $divideId = 0;
			}else{

        if ($_SESSION[self::MYTOKEN] != $_POST['my_token']) {
            if (/* 本番モード */) {
            //403
          }

          /* 編集モード */
          echo "Tokenチェックエラー"

          unset($_SESSION[self::REGTOKEN]);

				}else{
					  $token = $_POST['register_token'];
				}
			}

			//ログイン成功
			if($divideId == 1){
        $statusCode = 302;
        $targetUrl  = "http://www.example.com/";

        header("HTTP", true,  $statusCode);
        header("Location: " . $targetUrl );
      }
		}

```