<?php
/**
* 
*/
class Frame_Session
{
	static private $_start = false;
	
	static private function start() {
		if(!self::$_start){
			session_start();
			self::$_start = !self::$_start;
		}
	}
	
	
	static function modName($name) {
		self::start();
		return Frame_URS::$moduleName . '_'. ((is_array($name))? implode('_',$name):$name);
	}
	
	static function set($_name, $value){
		return $_SESSION[self::modName($_name)]=$value;
	}
	
	static function get($_name, $defaultValue=''){
		$name = self::modName($_name);
		return (isset($_SESSION[$name]))? $_SESSION[$name] : $_SESSION[$name]=$defaultValue;
	}
	
	static function rm($_name)
	{
		unset($_SESSION[self::modName($_name)]);
	}
	
	static function getAndDel($_name, $defaultValue=''){
		$name = self::modName($_name);
		$value = (isset($_SESSION[$name]))? $_SESSION[$name] : $_SESSION[$name]=$defaultValue;
		unset($_SESSION[$name]);
		return $value;
	}
}
