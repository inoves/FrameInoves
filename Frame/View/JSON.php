<?
/*
* Output de View em JSON
*/
class Frame_View_JSON{
	private $_view;

	function __construct() {
		header('Content-type: application/json');
	}

	function setView(Frame_View $view){
		$this->_view = $view;
	}

	public function renderOutput(){
		return self::encode(Frame_View::getInstance()->__vars);
	}

	static function encode($var){
	    return json_encode($var);
		//return Zend_Json::encode($var);
	}

	public function __toString(){
		return $this->renderOutput();
	}
}