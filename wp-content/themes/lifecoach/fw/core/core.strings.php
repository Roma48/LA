<?php
/**
 * LifeCoach Framework: strings manipulations
 *
 * @package	lifecoach
 * @since	lifecoach 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'LIFECOACH_MULTIBYTE' ) ) define( 'LIFECOACH_MULTIBYTE', function_exists('mb_strpos') ? 'UTF-8' : false );

if (!function_exists('lifecoach_strlen')) {
	function lifecoach_strlen($text) {
		return LIFECOACH_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('lifecoach_strpos')) {
	function lifecoach_strpos($text, $char, $from=0) {
		return LIFECOACH_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('lifecoach_strrpos')) {
	function lifecoach_strrpos($text, $char, $from=0) {
		return LIFECOACH_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('lifecoach_substr')) {
	function lifecoach_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = lifecoach_strlen($text)-$from;
		}
		return LIFECOACH_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}

if (!function_exists('lifecoach_strtolower')) {
	function lifecoach_strtolower($text) {
		return LIFECOACH_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('lifecoach_strtoupper')) {
	function lifecoach_strtoupper($text) {
		return LIFECOACH_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('lifecoach_strtoproper')) {
	function lifecoach_strtoproper($text) { 
		$rez = ''; $last = ' ';
		for ($i=0; $i<lifecoach_strlen($text); $i++) {
			$ch = lifecoach_substr($text, $i, 1);
			$rez .= lifecoach_strpos(' .,:;?!()[]{}+=', $last)!==false ? lifecoach_strtoupper($ch) : lifecoach_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('lifecoach_strrepeat')) {
	function lifecoach_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('lifecoach_strshort')) {
	function lifecoach_strshort($str, $maxlength, $add='...') {
	//	if ($add && lifecoach_substr($add, 0, 1) != ' ')
	//		$add .= ' ';
		if ($maxlength < 0) 
			return $str;
		if ($maxlength == 0) 
			return '';
		if ($maxlength >= lifecoach_strlen($str)) 
			return strip_tags($str);
		$str = lifecoach_substr(strip_tags($str), 0, $maxlength - lifecoach_strlen($add));
		$ch = lifecoach_substr($str, $maxlength - lifecoach_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = lifecoach_strlen($str) - 1; $i > 0; $i--)
				if (lifecoach_substr($str, $i, 1) == ' ') break;
			$str = trim(lifecoach_substr($str, 0, $i));
		}
		if (!empty($str) && lifecoach_strpos(',.:;-', lifecoach_substr($str, -1))!==false) $str = lifecoach_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('lifecoach_strclear')) {
	function lifecoach_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (is_array($tags) && count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (lifecoach_substr($text, 0, lifecoach_strlen($open))==$open) {
					$pos = lifecoach_strpos($text, '>');
					if ($pos!==false) $text = lifecoach_substr($text, $pos+1);
				}
				if (lifecoach_substr($text, -lifecoach_strlen($close))==$close) $text = lifecoach_substr($text, 0, lifecoach_strlen($text) - lifecoach_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}

// Return slug for the any title string
if (!function_exists('lifecoach_get_slug')) {
	function lifecoach_get_slug($title) {
		return lifecoach_strtolower(str_replace(array('\\','/','-',' ','.'), '_', $title));
	}
}

// Replace macros in the string
if (!function_exists('lifecoach_strmacros')) {
	function lifecoach_strmacros($str) {
		return str_replace(array("{{", "}}", "((", "))", "||"), array("<i>", "</i>", "<b>", "</b>", "<br>"), $str);
	}
}

// Unserialize string (try replace \n with \r\n)
if (!function_exists('lifecoach_unserialize')) {
	function lifecoach_unserialize($str) {
		if ( is_serialized($str) ) {
			try {
				$data = unserialize($str);
			} catch (Exception $e) {
				dcl($e->getMessage());
				$data = false;
			}
			if ($data===false) {
				try {
					$data = @unserialize(str_replace("\n", "\r\n", $str));
				} catch (Exception $e) {
					dcl($e->getMessage());
					$data = false;
				}
			}
			//if ($data===false) $data = @unserialize(str_replace(array("\n", "\r"), array('\\n','\\r'), $str));
			return $data;
		} else
			return $str;
	}
}
?>