<?
/**
* AutoLoad
*/
class Frame_Loader
{

	static private $_loadRegister=array();


	//Coloca no stack autoload a func load
	function __construct()
	{
		spl_autoload_register(array($this, 'load'));
	}

	//
	static function load($className)
	{
		$locationClass = str_replace("_", DIRECTORY_SEPARATOR, $className) . '.php';
		self::includeNow($locationClass);
	}


	static function includeNow($locationClass)
	{
		self::$_loadRegister[] = $locationClass;
		return include $locationClass;
	}

}
