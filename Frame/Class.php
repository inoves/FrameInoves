<?
/**
* Class base
* Todas as classes em cada camada deve ter uma classe base
* A camada Modelo deve ter uma classe base especifica
*
*/
class Frame_Class
{
	
	/*
	* Instancia de self
	*/
	static private $_instance=null;//false positive block
	
	/*
	* Singleton function
	*
	* @return instance __CLASS__	
	*/
	static public function getInstance($class){
		if(self::$_instance==null){
			self::$_instance = new $class;
		}
		return self::$_instance;
	}
	
	/**
     * Reset the singleton instance
     *
     * @return void
     */
    public static function resetInstance()
    {
        self::$_instance = null;
    }
}