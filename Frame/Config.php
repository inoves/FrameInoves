<?
/**
* Config
*/
class Frame_Config
{
	static private $___config;
	
	static function add($_configFile)
	{
		if(self::$___config)
			self::$___config->merge($_configFile);
		else
			self::$___config = $_configFile;
		return self::$___config;
	}
	
	static function get()
	{
		if(self::$___config)
			return self::$___config;
		else
			throw new Frame_Exception('Get config file error.');
	}
}
