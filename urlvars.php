<?php

class UrlVars {
	private static $url_chars = array('_', 'o~', 'a:', 'o:', 'u:', 's:', 'z:', 'O~', 'A:', 'O:', 'U:', 'S:', 'Z:');
	private static $real_chars = array(' ', 'õ', 'ä', 'ö', 'ü', 'š', 'ž', 'Õ', 'Ä', 'Ö', 'Ü', 'Š', 'Ž');

	function url2real($text)
	{
		return str_replace(self::$url_chars, self::$real_chars, $text);
	}

	function real2url($text)
	{
		return str_replace(self::$real_chars, self::$url_chars, $text);
	}

}

?>