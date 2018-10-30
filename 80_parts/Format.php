<?php

    /**
	 * 
	 */
	public static function sharpen($str) {
		// htmlspecialchars($str, ENT_QUOTES);
		$str = MSM_Utils_Text::escHtml($str);
		$str = preg_replace('#\r?\n#u', ' ', $str);
		$str = preg_replace('#\t#u', ' ', $str);
		$str = preg_replace('#^[ 　]+#u', '', $str);
		$str = preg_replace('#[ 　]+$#u', '', $str);
		return $str;
	}
