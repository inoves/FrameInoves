<?php
class Frame_MongoTb
{	
	const PER_PAGE = 15;
	
	public $_table;
	
	function __call($name, $args) {
		return call_user_func_array(
				array(
					Frame_Connect::getTableMongo($this->_table), $name
					), $args);
	}
	
	
	function MongoSanatize($var) {

	    if (is_array($var)) {

	        $newVar = array();

	        foreach($var as $key => $value)
	        {
	            $newKey = $key;

	            if (is_string($key))
	                $newKey = str_replace(array(chr(0), '$'), '', $key);

	            if (is_array($value))
	                $newVar[$newKey] = MongoSanatize($value);
	            else
	                $newVar[$newKey] = $value;
	        }

	        return $newVar;
	    }

	    return $var;
	}
}