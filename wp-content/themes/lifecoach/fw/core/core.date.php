<?php
/**
 * LifeCoach Framework: date and time manipulations
 *
 * @package	lifecoach
 * @since	lifecoach 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Convert date from MySQL format (YYYY-mm-dd) to Date (dd.mm.YYYY)
if (!function_exists('lifecoach_sql_to_date')) {
	function lifecoach_sql_to_date($str) {
		return (trim($str)=='' || trim($str)=='0000-00-00' ? '' : trim(lifecoach_substr($str,8,2).'.'.lifecoach_substr($str,5,2).'.'.lifecoach_substr($str,0,4).' '.lifecoach_substr($str,11)));
	}
}

// Convert date from Date format (dd.mm.YYYY) to MySQL format (YYYY-mm-dd)
if (!function_exists('lifecoach_date_to_sql')) {
	function lifecoach_date_to_sql($str) {
		if (trim($str)=='') return '';
		$str = strtr(trim($str),'/\-,','....');
		if (trim($str)=='00.00.0000' || trim($str)=='00.00.00') return '';
		$pos = lifecoach_strpos($str,'.');
		$d=trim(lifecoach_substr($str,0,$pos));
		$str=lifecoach_substr($str,$pos+1);
		$pos = lifecoach_strpos($str,'.');
		$m=trim(lifecoach_substr($str,0,$pos));
		$y=trim(lifecoach_substr($str,$pos+1));
		$y=($y<50?$y+2000:($y<1900?$y+1900:$y));
		return ''.($y).'-'.(lifecoach_strlen($m)<2?'0':'').($m).'-'.(lifecoach_strlen($d)<2?'0':'').($d);
	}
}

// Return difference or date
if (!function_exists('lifecoach_get_date_or_difference')) {
	function lifecoach_get_date_or_difference($dt1, $dt2=null, $max_days=-1) {
		static $gmt_offset = 999;
		if ($gmt_offset==999) $gmt_offset = (int) get_option('gmt_offset');
		if ($max_days < 0) $max_days = lifecoach_get_theme_option('show_date_after', 30);
		if ($dt2 == null) $dt2 = date('Y-m-d H:i:s');
		$dt2n = strtotime($dt2)+$gmt_offset*3600;
		$dt1n = strtotime($dt1);
		if (is_numeric($dt1n) && is_numeric($dt2n)) {
			$diff = $dt2n - $dt1n;
			$days = floor($diff / (24*3600));
			if (abs($days) < $max_days)
				return sprintf($days >= 0 ? esc_html__('%s ago', 'lifecoach') : esc_html__('in %s', 'lifecoach'), lifecoach_get_date_difference($days >= 0 ? $dt1 : $dt2, $days >= 0 ? $dt2 : $dt1));
			else
				return lifecoach_get_date_translations(date(get_option('date_format'), $dt1n));
		} else
			return lifecoach_get_date_translations($dt1);
	}
}

// Difference between two dates
if (!function_exists('lifecoach_get_date_difference')) {
	function lifecoach_get_date_difference($dt1, $dt2=null, $short=1, $sec = false) {
		static $gmt_offset = 999;
		if ($gmt_offset==999) $gmt_offset = (int) get_option('gmt_offset');
		if ($dt2 == null) $dt2n = time()+$gmt_offset*3600;
		else $dt2n = strtotime($dt2)+$gmt_offset*3600;
		$dt1n = strtotime($dt1);
		if (is_numeric($dt1n) && is_numeric($dt2n)) {
			$diff = $dt2n - $dt1n;
			$days = floor($diff / (24*3600));
			$months = floor($days / 30);
			$diff -= $days * 24 * 3600;
			$hours = floor($diff / 3600);
			$diff -= $hours * 3600;
			$min = floor($diff / 60);
			$diff -= $min * 60;
			$rez = '';
			if ($months > 0 && $short == 2)
				$rez .= ($rez!='' ? ' ' : '') . sprintf($months > 1 ? esc_html__('%s months', 'lifecoach') : esc_html__('%s month', 'lifecoach'), $months);
			if ($days > 0 && ($short < 2 || $rez==''))
				$rez .= ($rez!='' ? ' ' : '') . sprintf($days > 1 ? esc_html__('%s days', 'lifecoach') : esc_html__('%s day', 'lifecoach'), $days);
			if ((!$short || $rez=='') && $hours > 0)
				$rez .= ($rez!='' ? ' ' : '') . sprintf($hours > 1 ? esc_html__('%s hours', 'lifecoach') : esc_html__('%s hour', 'lifecoach'), $hours);
			if ((!$short || $rez=='') && $min > 0)
				$rez .= ($rez!='' ? ' ' : '') . sprintf($min > 1 ? esc_html__('%s minutes', 'lifecoach') : esc_html__('%s minute', 'lifecoach'), $min);
			if ($sec || $rez=='')
				$rez .=  $rez!='' || $sec ? (' ' . sprintf($diff > 1 ? esc_html__('%s seconds', 'lifecoach') : esc_html__('%s second', 'lifecoach'), $diff)) : esc_html__('less then minute', 'lifecoach');
			return $rez;
		} else
			return $dt1;
	}
}

// Prepare month names in date for translation
if (!function_exists('lifecoach_get_date_translations')) {
	function lifecoach_get_date_translations($dt) {
		return str_replace(
			array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',
				  'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
			array(
				esc_html__('January', 'lifecoach'),
				esc_html__('February', 'lifecoach'),
				esc_html__('March', 'lifecoach'),
				esc_html__('April', 'lifecoach'),
				esc_html__('May', 'lifecoach'),
				esc_html__('June', 'lifecoach'),
				esc_html__('July', 'lifecoach'),
				esc_html__('August', 'lifecoach'),
				esc_html__('September', 'lifecoach'),
				esc_html__('October', 'lifecoach'),
				esc_html__('November', 'lifecoach'),
				esc_html__('December', 'lifecoach'),
				esc_html__('Jan', 'lifecoach'),
				esc_html__('Feb', 'lifecoach'),
				esc_html__('Mar', 'lifecoach'),
				esc_html__('Apr', 'lifecoach'),
				esc_html__('May', 'lifecoach'),
				esc_html__('Jun', 'lifecoach'),
				esc_html__('Jul', 'lifecoach'),
				esc_html__('Aug', 'lifecoach'),
				esc_html__('Sep', 'lifecoach'),
				esc_html__('Oct', 'lifecoach'),
				esc_html__('Nov', 'lifecoach'),
				esc_html__('Dec', 'lifecoach'),
			),
			$dt);
	}
}
?>