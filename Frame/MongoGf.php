<?php
/**
 * 
 */
class Frame_MongoGf
{	
	
	public $_table;
	
	function __call($name, $args) {
		$grid = Frame_Connect::conMongo()->getGridFS($this->_table);
		return call_user_func_array(array($grid, $name), $args);
	}
	
}