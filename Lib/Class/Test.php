<?php 

/**
* teste de implementa de uma biblioteca de exemplo
* @example: Lib_Class_Example::ola('mundo')
*/
class Lib_Class_Example
{
	
	static public function ola($gender)
	{
		echo __FUNCTION__.' '.$gender;
	}
}
