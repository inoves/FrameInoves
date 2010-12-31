<?
/**
* 
*/
class Frame_Registry
{
	static function get($name)
	{
			$v = Zend_Registry::get($name);
			if(!$v || $v==null)
				$v = Frame_Session::get($name);
				if(!$v || $v==null)
					$v = Frame_View::get($name);
		return $v;
	}
	static function set($name, $value)
	{
		return Zend_Registry::set($name,$value);
	}
}
