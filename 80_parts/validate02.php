<?php

class MyUtilClass {

    protected function checkForToken(){
        if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
            echo "Invalid Token!";
            exit;
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
        if (!isset($parameterValue) || MY_Utils::custom_trim($parameterValue) == "") {
            $this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
        }
    }

    protected function checkForRequiredSelect($variableName, $parameterValue){
        if (!isset($parameterValue) || MY_Utils::custom_trim($parameterValue) == "") {
            $this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
        }
    }
    
    protected function checkForEmailStyle($variableName, $parameterValue){
        if (!	filter_var($parameterValue, FILTER_VALIDATE_EMAIL)) {
            $this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
        }
    }

    protected function checkForTelStyle($variableName, $parameterValue){
        if (!isset($parameterValue) || $parameterValue == "") {
            return "";
        }

        // 「0～9」「-」 「()」「+」 の入力のみを許可。
        //  例：(03)4516-7841、+81-3-9842-1147
        if (!preg_match('/\A[\d-()+]{1,}\z/', $parameterValue)) {
            $this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
        }
    }

    protected function checkForUrlStyle($variableName, $parameterValue){
        if (!isset($parameterValue) || $parameterValue == "") {
            return "";
        }

        if (!filter_var($parameterValue, FILTER_VALIDATE_URL)) {
            $this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
        }
    }

    protected function checkForPasswordPolicy($variableName, $parameterValue){
        if (!isset($parameterValue) || $parameterValue == "") {
            return "";
        }

        // 半角英数字（半角記号含む）4文字以上8文字以内
        if (!preg_match('/\A[!-~]{4,8}\z/', $parameterValue)) {
            $this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
        }
    }

	protected function checkForDateFormat($variableName, $parameterValue){
		if (!isset($parameterValue) || $parameterValue == "") {
			return "";
		}

		$dataArray = explode("/", $parameterValue);
		if(count($dataArray) < 3){
			$dataArray = explode("-", $parameterValue);
		}

		if(count($dataArray) >= 3){
			if(checkdate($dataArray[1], $dataArray[2], $dataArray[0])) {
				return "";
			} else {
				$this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
				return "";
			}

		}else{
			if(count($dataArray) >= 1){
				if(strlen($dataArray[0]) != 8){
					return "";
					$this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
				}else{
					$yyyy = substr($dataArray[0], 0 , 4);
					$mm   = substr($dataArray[0], 4 , 2);
					$dd   = substr($dataArray[0], 6 , 4);
					if(checkdate($mm, $dd, $yyyy)) {
						return "";
					} else {
						$this->errContentArray[$variableName] = self::CONTAIN_ERROR_VALUE;
						return "";
					}
				}
			}else{
				return "";
			}
		}
	}


}
