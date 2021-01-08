<?php

class Project_Utils {
	public static $general_message = [];

	public static $image_path = "/project01/";

	public static function setJmesseMessage($db, $pageId, $revision) {

		if(Lang_Utils::getPageLang($db, $pageId, $revision) == "en"){
			self::$general_message =
			[
				 'email'        => "email"
				,'password'     => "password"
				,'company_name' => "company name"
				,'user_nm'      => "name"
				,'address'      => "address"
				,'tel'          => "TEL"
				,'url'          => "URL"
				,'validate_error_message_for_required'        => "%s has not been entered."
				,'validate_error_message_for_invalid_input'   => "%s input is invalid."
				,'validate_error_message_for_email_style'     => "%s input is invalid.([@] and [.] are required.)"
				,'validate_error_message_for_duplicate_email' => "The email you entered is already in use."
				,'validate_error_message_for_password_policy' => "Please enter the password within %s to %s letters."
			];
		}
		else{
			self::$general_message =
			[
				 'email'        => "Eメール"
				,'password'     => "パスワード"
				,'company_name' => "会社名"
				,'user_nm'      => "氏名"
				,'address'      => "住所"
				,'tel'          => "TEL"
				,'url'          => "URL"
				,'validate_error_message_for_required'        => "%sが入力されていません"
				,'validate_error_message_for_invalid_input'   => "%sの入力が不正です。"
				,'validate_error_message_for_email_style'     => "%sの入力が不正です。（「@」と「.」が必要です。）"
				,'validate_error_message_for_duplicate_email' => "入力されたEメールは既に使用されています。"
				,'validate_error_message_for_password_policy' => "パスワードは、%s文字以上%s文字以内で入力してください。"
			];
		}
	}


	const SEARCH_VALUE_HEADER = "search_value_";
	const SEARCH_CONDITION_HEADER = "search_condition_";	

	public static function setBindValueFromUserParam(&$stmt, $parameters) {
		foreach ($parameters as $key => $value) {
			// if($key ){

			// }

			// $pos = strpos($key, $SEARCH_VALUE_HEADER);
			// echo "$pos";
			// echo "($key) $value ";


			if(strpos($key, self::SEARCH_VALUE_HEADER) === 0){
				$parameter_name = $key;


				echo "($key) $value ";

				// if($_POST['search_condition_email'] == "2"){
				// 	$stmt->bindValue(':email', "%". $_POST['search_email'] ."%");
				// }else{
				// 	$stmt->bindValue(':email', $_POST['search_email']);
				// }

				if(strpos($key, self::SEARCH_CONDITION_HEADER) === 0){

				}
			}

			// echo "$pos";
		}

	}


