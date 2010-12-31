<?

/*
* Output de View em XML
*/
class View_XML extends Frame_View {
	
	private $_view;
	
	public static $rootResult = 'result';

	function __construct() {
		header('Content-type: text/xml');
	}

	function setView(Frame_View $view){
		$this->_view = $view;
	}

	public function renderOutput(){
		return self::encode(Frame_View::getInstance()->__vars);
	}

	static function encode($var){
		$xml = '<'+self::$rootResult+'>';
			$xml .= self::makeXml($var);
		$xml .= '</'+self::$rootResult+'>';
	    return $xml;
	}
	
	static public function makeXml($var)
	{
		$xml = '';
		foreach ($var as $key => $value) {
			$xml .= '<'.$key.'>';
				if(is_array($value))
					$xml .= self::makeXml($value);
				else
					$xml .= $value;
			$xml .= '</'.$key.'>';
		}
		return $xml;
	}

	public function __toString(){
		return $this->renderOutput();
	}
	
	
}
