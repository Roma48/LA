<?php
/**
 * LifeCoach Framework: theme variables storage
 *
 * @package	lifecoach
 * @since	lifecoach 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('lifecoach_storage_get')) {
	function lifecoach_storage_get($var_name, $default='') {
		global $LIFECOACH_STORAGE;
		return isset($LIFECOACH_STORAGE[$var_name]) ? $LIFECOACH_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('lifecoach_storage_set')) {
	function lifecoach_storage_set($var_name, $value) {
		global $LIFECOACH_STORAGE;
		$LIFECOACH_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('lifecoach_storage_empty')) {
	function lifecoach_storage_empty($var_name, $key='', $key2='') {
		global $LIFECOACH_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($LIFECOACH_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($LIFECOACH_STORAGE[$var_name][$key]);
		else
			return empty($LIFECOACH_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('lifecoach_storage_isset')) {
	function lifecoach_storage_isset($var_name, $key='', $key2='') {
		global $LIFECOACH_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($LIFECOACH_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($LIFECOACH_STORAGE[$var_name][$key]);
		else
			return isset($LIFECOACH_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('lifecoach_storage_inc')) {
	function lifecoach_storage_inc($var_name, $value=1) {
		global $LIFECOACH_STORAGE;
		if (empty($LIFECOACH_STORAGE[$var_name])) $LIFECOACH_STORAGE[$var_name] = 0;
		$LIFECOACH_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('lifecoach_storage_concat')) {
	function lifecoach_storage_concat($var_name, $value) {
		global $LIFECOACH_STORAGE;
		if (empty($LIFECOACH_STORAGE[$var_name])) $LIFECOACH_STORAGE[$var_name] = '';
		$LIFECOACH_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('lifecoach_storage_get_array')) {
	function lifecoach_storage_get_array($var_name, $key, $key2='', $default='') {
		global $LIFECOACH_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($LIFECOACH_STORAGE[$var_name][$key]) ? $LIFECOACH_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($LIFECOACH_STORAGE[$var_name][$key][$key2]) ? $LIFECOACH_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('lifecoach_storage_set_array')) {
	function lifecoach_storage_set_array($var_name, $key, $value) {
		global $LIFECOACH_STORAGE;
		if (!isset($LIFECOACH_STORAGE[$var_name])) $LIFECOACH_STORAGE[$var_name] = array();
		if ($key==='')
			$LIFECOACH_STORAGE[$var_name][] = $value;
		else
			$LIFECOACH_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('lifecoach_storage_set_array2')) {
	function lifecoach_storage_set_array2($var_name, $key, $key2, $value) {
		global $LIFECOACH_STORAGE;
		if (!isset($LIFECOACH_STORAGE[$var_name])) $LIFECOACH_STORAGE[$var_name] = array();
		if (!isset($LIFECOACH_STORAGE[$var_name][$key])) $LIFECOACH_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$LIFECOACH_STORAGE[$var_name][$key][] = $value;
		else
			$LIFECOACH_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Add array element after the key
if (!function_exists('lifecoach_storage_set_array_after')) {
	function lifecoach_storage_set_array_after($var_name, $after, $key, $value='') {
		global $LIFECOACH_STORAGE;
		if (!isset($LIFECOACH_STORAGE[$var_name])) $LIFECOACH_STORAGE[$var_name] = array();
		if (is_array($key))
			lifecoach_array_insert_after($LIFECOACH_STORAGE[$var_name], $after, $key);
		else
			lifecoach_array_insert_after($LIFECOACH_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('lifecoach_storage_set_array_before')) {
	function lifecoach_storage_set_array_before($var_name, $before, $key, $value='') {
		global $LIFECOACH_STORAGE;
		if (!isset($LIFECOACH_STORAGE[$var_name])) $LIFECOACH_STORAGE[$var_name] = array();
		if (is_array($key))
			lifecoach_array_insert_before($LIFECOACH_STORAGE[$var_name], $before, $key);
		else
			lifecoach_array_insert_before($LIFECOACH_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('lifecoach_storage_push_array')) {
	function lifecoach_storage_push_array($var_name, $key, $value) {
		global $LIFECOACH_STORAGE;
		if (!isset($LIFECOACH_STORAGE[$var_name])) $LIFECOACH_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($LIFECOACH_STORAGE[$var_name], $value);
		else {
			if (!isset($LIFECOACH_STORAGE[$var_name][$key])) $LIFECOACH_STORAGE[$var_name][$key] = array();
			array_push($LIFECOACH_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('lifecoach_storage_pop_array')) {
	function lifecoach_storage_pop_array($var_name, $key='', $defa='') {
		global $LIFECOACH_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($LIFECOACH_STORAGE[$var_name]) && is_array($LIFECOACH_STORAGE[$var_name]) && count($LIFECOACH_STORAGE[$var_name]) > 0) 
				$rez = array_pop($LIFECOACH_STORAGE[$var_name]);
		} else {
			if (isset($LIFECOACH_STORAGE[$var_name][$key]) && is_array($LIFECOACH_STORAGE[$var_name][$key]) && count($LIFECOACH_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($LIFECOACH_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('lifecoach_storage_inc_array')) {
	function lifecoach_storage_inc_array($var_name, $key, $value=1) {
		global $LIFECOACH_STORAGE;
		if (!isset($LIFECOACH_STORAGE[$var_name])) $LIFECOACH_STORAGE[$var_name] = array();
		if (empty($LIFECOACH_STORAGE[$var_name][$key])) $LIFECOACH_STORAGE[$var_name][$key] = 0;
		$LIFECOACH_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('lifecoach_storage_concat_array')) {
	function lifecoach_storage_concat_array($var_name, $key, $value) {
		global $LIFECOACH_STORAGE;
		if (!isset($LIFECOACH_STORAGE[$var_name])) $LIFECOACH_STORAGE[$var_name] = array();
		if (empty($LIFECOACH_STORAGE[$var_name][$key])) $LIFECOACH_STORAGE[$var_name][$key] = '';
		$LIFECOACH_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('lifecoach_storage_call_obj_method')) {
	function lifecoach_storage_call_obj_method($var_name, $method, $param=null) {
		global $LIFECOACH_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($LIFECOACH_STORAGE[$var_name]) ? $LIFECOACH_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($LIFECOACH_STORAGE[$var_name]) ? $LIFECOACH_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('lifecoach_storage_get_obj_property')) {
	function lifecoach_storage_get_obj_property($var_name, $prop, $default='') {
		global $LIFECOACH_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($LIFECOACH_STORAGE[$var_name]->$prop) ? $LIFECOACH_STORAGE[$var_name]->$prop : $default;
	}
}
?>