<?php


class SpUser {
		public function __set($key,$value){}
		public function __get($name)
		{
			if($name == "hasError") {
				if(count($this->errMessageArray) > 0){
					return true;
				}else{
					return false;
				}

			}
			elseif($name == "errMessage") {
				if(count($this->errMessageArray) > 0){
					return join('<br>', $this->errMessageArray);
				}else{
					return "";
				}
			}
		}
    }


