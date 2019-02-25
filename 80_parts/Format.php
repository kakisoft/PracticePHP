<?php

    /**
	 * 以下を削除
	 * 　・左右の半角空白および全角空白
	 * 　・タブ
	 * 　・改行
	 * 
	 */
	public static function sharpen($str) {
		// htmlspecialchars($str, ENT_QUOTES);
		$str = preg_replace('#\r?\n#u', ' ', $str);
		$str = preg_replace('#\t#u', ' ', $str);
		$str = preg_replace('#^[ 　]+#u', '', $str);
		$str = preg_replace('#[ 　]+$#u', '', $str);
		return $str;
	}