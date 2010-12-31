<?php
/**
* @example
* Frame_Cookie::set(array('user', 'name'), 'valueName')
* Frame_Cookie::set(array('user', 'id'), 'valueId')
*
* $userId = Frame_Cookie::get(array('user', 'id'))
*/
class Frame_Cookie
{
	static function modName($name) {
		return Frame_URS::$moduleName . '_'. ((is_array($name))? implode('_',$name):$name);
	}
	
	static function set($_name, $value, $atomic=true, $expire=0){
		$name = self::modName($_name);
		setcookie($name, $value, $expire);
		
		if($atomic)
			$_COOKIE[$name]=$value;
	}
	
	static function get($_name, $defaultValue=null){
		$name = self::modName($_name);
		return (isset($_COOKIE[$name]))? $_COOKIE[$name] : $defaultValue;
	}
}
