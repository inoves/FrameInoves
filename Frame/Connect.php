<?
/**
database.driver          = mysql
database.adapter         = pdo_mysql
database.params.host     = localhost
database.params.username = dbuser
database.params.password = secret
database.params.dbname   = inov.es
*/

class Frame_Connect
{
	
	static private $_conMongo = null;
	static private $_conMysql = null;
	static $cache = false;
	
	//mongo
	static function setConMongo($con){self::$_conMongo = $con;}
	static function conMongo(){return self::$_conMongo;}
	static function getTableMongo($tableName){return self::conMongo()->$tableName;}
	
	//mysql
	static function setConMysql($con){self::$_conMysql = $con;}
	static function getConMysql(){return self::$_conMysql;}
	static function close(){self::conMysql()->close();}
	
}
