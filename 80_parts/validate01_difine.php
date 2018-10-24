<?php

class MY_LANG_Util_01 {
    const DEFAULT_LANG = "ja";

    public static $util_message = [];

	/**
	 * 多言語対応：メッセージ管理
	 *
	 * @param number $name         a
	 * @param number $id           bb
	 * @param string $discription  ccc
	 * 
	 */
	public static function setUtilMessage() {

		if(MY_Util_02::getLang() == "en"){
			self::$util_message =
			[
				 'email'                    => "ID(mail address)"
				,'email_confirm'            => "Confirmation ID(mail address)"
				,'password'                 => "password"
				,'company_name'             => "company name"
				,'user_nm'                  => "name"
				,'address'                  => "address"
				,'tel'                      => "TEL"
				,'url'                      => "URL"
				,'admin'                    => "Authority"
				,'use_lang_cd'              => "User language"
				,'regist_result_notice_flg' => "Registration notification mail"
				,'validate_error_message_for_required'            => "%s has not been entered."
				,'validate_error_message_for_required_select'     => "%s has not been selected."
				,'validate_error_message_for_invalid_input'       => "%s input is invalid."
				,'validate_error_message_for_email_style'         => "%s input is invalid."
				,'validate_error_message_for_confirm_email_match' => "The ID (mail address) and confirmation ID (mail address) are different."
				,'validate_error_message_for_duplicate_email'     => "The email you entered is already in use."
				,'validate_error_message_for_password_policy'     => "Please enter the password within %s to %s letters."
			];
		}
		else{
			self::$util_message =
			[
				 'email'                    => "ID(メールアドレス)"
				,'email_confirm'            => "確認用ID(メールアドレス)"
				,'password'                 => "パスワード"
				,'company_name'             => "会社名"
				,'user_nm'                  => "氏名"
				,'address'                  => "住所"
				,'tel'                      => "TEL"
				,'url'                      => "URL"
				,'admin'                    => "権限"
				,'use_lang_cd'              => "ユーザの使用言語"
				,'regist_result_notice_flg' => "登録通知メール"
				,'validate_error_message_for_required'            => "%sを入力してください。"
				,'validate_error_message_for_required_select'     => "%sを選択してください。"
				,'validate_error_message_for_invalid_input'       => "%sを正しく入力してください。"
				,'validate_error_message_for_email_style'         => "%sを正しく入力してください。"
				,'validate_error_message_for_confirm_email_match' => "ID（メールアドレス）と確認用ID（メールアドレス）が異なっています。"
				,'validate_error_message_for_duplicate_email'     => "入力されたEメールは既に使用されています。"
				,'validate_error_message_for_password_policy'     => "パスワードは、%s文字以上%s文字以内で入力してください。"
			];
		}
	}

}


/***********************************************
 *                ベースクラス
 * 
 *  ・Validation
 *  ・エラー状態・エラーメッセージ管理
 * 　等
 ***********************************************/
class XiJmesseBaseClass {
	const ERROR_MESSAGE_SEPARATOR = "<br>";
	public $errMessageArray = ["0", "Error checking Not execute yet"];  //Smarty側からもエラー内容を取り出せるようにするため、スコープを publicにしています。
	public $hasError   = false; //本当は publicのgetterとprivateのsetterにしたかったけど、Smartyで取り出せるようにするため、スコープを publicにしています。
	public $errMessage = "Error checking Not execute yet"; //同上

	protected function setErrorJudgmentProperties(){
		//Has Error
		if(count($this->errMessageArray) > 0){
			$this->hasError = true;
		}else{
			$this->hasError = false;
		}				
	
		//Error Message
		if(count($this->errMessageArray) > 0){
			$this->errMessage = join(self::ERROR_MESSAGE_SEPARATOR, $this->errMessageArray);
		}else{
			$this->errMessage = "";
		}
	}

	protected function setErrorContentParams($mainKey, $subKeys){
		foreach ($subKeys as $value) {
			if($this->errContentArray[$value] == self::CONTAIN_ERROR_VALUE){
				$this->errContentArray[$mainKey] = self::CONTAIN_ERROR_VALUE;
				return;
			}
		}
	}

	protected function checkForRequired($variableName, $parameterValue){
		if (!isset($parameterValue) || Xi_Jetro_Plugin_Utils::mb_trim($parameterValue) == "") {
			if(trim($this->errMessageArray[$variableName]) != ""){
				$this->errMessageArray[$variableName] .= self::ERROR_MESSAGE_SEPARATOR;
			}
			$this->errMessageArray[$variableName] .= sprintf(MY_LANG_Util_01::$util_message['validate_error_message_for_required'], MY_LANG_Util_01::$util_message[$variableName]);
		}
	}

	protected function checkForRequiredSelect($variableName, $parameterValue){
		if (!isset($parameterValue) || Xi_Jetro_Plugin_Utils::mb_trim($parameterValue) == "") {
			if(trim($this->errMessageArray[$variableName]) != ""){
				$this->errMessageArray[$variableName] .= self::ERROR_MESSAGE_SEPARATOR;
			}
			$this->errMessageArray[$variableName] .= sprintf(MY_LANG_Util_01::$util_message['validate_error_message_for_required_select'], MY_LANG_Util_01::$util_message[$variableName]);
		}
	}
	
	protected function checkForEmailStyle($variableName, $parameterValue){
		if (!filter_var($parameterValue, FILTER_VALIDATE_EMAIL)) {
			if(trim($this->errMessageArray[$variableName]) != ""){
				$this->errMessageArray[$variableName] .= self::ERROR_MESSAGE_SEPARATOR;
			}
			$this->errMessageArray[$variableName] .= sprintf(MY_LANG_Util_01::$util_message['validate_error_message_for_email_style'], MY_LANG_Util_01::$util_message[$variableName]);
		}
	}

	protected function checkForEmailConfirmInput($variableName, $parameterValue1, $parameterValue2){
		if($parameterValue1 !== $parameterValue2){
			if(trim($this->errMessageArray[$variableName]) != ""){
				$this->errMessageArray[$variableName] .= self::ERROR_MESSAGE_SEPARATOR;
			}
			$this->errMessageArray[$variableName] .= sprintf(MY_LANG_Util_01::$util_message['validate_error_message_for_confirm_email_match'], MY_LANG_Util_01::$util_message[$variableName]);
		}
	}

	protected function checkForTelStyle($variableName, $parameterValue){
		if (!isset($parameterValue) || $parameterValue == "") {
			return "";
		}

		// 「0～9」「-」 「()」「+」 の入力のみを許可。
		//  例：(03)4516-7841、+81-3-9842-1147
		if (!preg_match('/\A[\d-()+]{1,}\z/', $parameterValue)) {
			if(trim($this->errMessageArray[$variableName]) != ""){
				$this->errMessageArray[$variableName] .= self::ERROR_MESSAGE_SEPARATOR;
			}
			$this->errMessageArray[$variableName] .= sprintf(MY_LANG_Util_01::$util_message['validate_error_message_for_invalid_input'], MY_LANG_Util_01::$util_message[$variableName]);
		}
	}
	
	protected function checkForUrlStyle($variableName, $parameterValue){
		if (!isset($parameterValue) || $parameterValue == "") {
			return "";
		}

		if (!filter_var($parameterValue, FILTER_VALIDATE_URL)) {
			if(trim($this->errMessageArray[$variableName]) != ""){
				$this->errMessageArray[$variableName] .= self::ERROR_MESSAGE_SEPARATOR;
			}
			$this->errMessageArray[$variableName] .= sprintf(MY_LANG_Util_01::$util_message['validate_error_message_for_invalid_input'], MY_LANG_Util_01::$util_message[$variableName]);
		}
	}

	protected function checkForDuplicateEmail($variableName, $parameterValue, $subValue=""){
		if (!isset($parameterValue) || $parameterValue == "") {
			return "";
		}

		$db = UTILS_DB::slave();
		$stmt = $db->prepare("SELECT id FROM users WHERE email = :email ");
		$stmt->bindValue(':email', $parameterValue);
		$stmt->execute();
		$recordCount    = $stmt->rowCount(MY_DB_CONST::FETCH_ASSOC);
		$recordInstance = $stmt->fetchAll(MY_DB_CONST::FETCH_ASSOC);

		if(     ($subValue == "" && $recordCount > 0) 
			 || ($subValue != "" && $recordCount > 0 && $subValue != $recordInstance[0]['id'])
		  ){
			if(trim($this->errMessageArray[$variableName]) != ""){
				$this->errMessageArray[$variableName] .= self::ERROR_MESSAGE_SEPARATOR;
			}
			$this->errMessageArray[$variableName] .= sprintf(MY_LANG_Util_01::$util_message['validate_error_message_for_duplicate_email']);
		}
	}

	protected function checkForPasswordPolicy($variableName, $parameterValue){
		// 半角英数字（半角記号含む）4文字以上8文字以内
		if (!preg_match('/\A[!-~]{4,8}\z/', $parameterValue)) {
			if(trim($this->errMessageArray[$variableName]) != ""){
				$this->errMessageArray[$variableName] .= self::ERROR_MESSAGE_SEPARATOR;
			}
			$this->errMessageArray[$variableName] .= sprintf(MY_LANG_Util_01::$util_message['validate_error_message_for_password_policy'], 4, 8);
		}
	}

	// protected function checkForDateFormat($variableName, $parameterValue){
	// 	if (!isset($parameterValue) || $parameterValue == "") {
	// 		return "";
	// 	}

	// 	$dataArray = explode("/", $parameterValue);
	// 	if(count($dataArray) < 3){
	// 		$dataArray = explode("-", $parameterValue);
	// 	}

	// 	if(count($dataArray) >= 3){
	// 		if(checkdate($dataArray[1], $dataArray[2], $dataArray[0])) {
	// 			return "";
	// 		} else {
	// 			$this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
	// 			return "";
	// 		}

	// 	}else{
	// 		if(count($dataArray) >= 1){
	// 			if(strlen($dataArray[0]) != 8){
	// 				return "";
	// 				$this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
	// 			}else{
	// 				$yyyy = substr($dataArray[0], 0, 4);
	// 				$mm   = substr($dataArray[0], 4, 2);
	// 				$dd   = substr($dataArray[0], 6, 4);
	// 				if(checkdate($mm, $dd, $yyyy)) {
	// 					return "";
	// 				} else {
	// 					$this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
	// 					return "";
	// 				}
	// 			}
	// 		}else{
	// 			return "";
	// 		}
	// 	}
	// }


}
