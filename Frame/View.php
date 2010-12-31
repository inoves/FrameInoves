<?
/*
* Guarda os dados da camada view
* Estes dados depois são manipulados pelo formato seleccionado, HTML, JSON, XML, SOAP..
*
*
*/
class Frame_View extends Frame_Class
{

	//Variaveis usadas na camada view
	public $__vars;

	//
	private $__disableLayout = false;


	//nome do arquivo layout, se false então não ha layout
	public $layout = 'layout/default';


	//URS passsado no construtors
	public $URS;

	//Formatos suportados pela camada View
	static public $formatSupported	= array('HTML', 'JSON', 'XML', 'MOBILE', 'ANDROID', 'IPHONE', 'TABLE');

	//formato padrão, caso não seja definido
	static public $defaultFormat	= 'HTML';

	//
	public $moduleName;
	public $controllerName;
	public $actionNameTemplate;
	public $actionName;
	public $format;

	//caminho utilizado para a camada VIEW
	private $_pathView;

	//partials addons
	private $_partials = array();


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author steven koch
	 **/
	public static function setPartial(Frame_View_Partial $partial, $partialArea)
	{
		self::getInstance()->_partials[$partialArea][]=$partial;
	}
	
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author steven koch
	 **/
	public static function getPartial($partialArea)
	{
		return implode( "\n\n", self::getInstance()->_partials[$partialArea]);
	}

	/*
	* Guarda o URS
	*
	*/
	static function setURS(Frame_URS $URS)
	{
		self::getInstance()->moduleName = Frame_URS::$moduleName;
		self::getInstance()->controllerName = Frame_URS::$controllerName;
		self::getInstance()->actionName = Frame_URS::$actionName;
		self::getInstance()->format = Frame_URS::$format;
		self::getInstance()->URS = $URS;
	}



	/*
	* Desactiva render do layout, util para chamadas AJAX em formato HTML
	*
	*/
	static function setDisableLayout($value=true)
	{
		self::getInstance()->__disableLayout = $value;
	}


	/*
	* Guarda ficheiro layout por defeito
	*
	*/
	static function setLayout($value='', $moduleName=null)
	{
		if($moduleName)
		 	self::getInstance()->_pathView = FRAME_PATH.'/'.DIR_MODULES_NAME.'/'.$moduleName.'/View/'.self::getInstance()->format."/";
		self::getInstance()->layout = $value;
	}



	//
	static function disabledLayout()
	{
		return self::getInstance()->__disableLayout;
	}



	/*
	* guarda um valor na view
	* @example:
	*	usado no controller
			Frame_View::set('nome', $value);
		ou
			Frame_View::getIntance()->nome = $value;
	*
	*/
	static function set($name, $value){
		self::getInstance()->__vars[$name]=$value;
		return $value;
	}



	/*
	* Retorna o valor guardado na view
	* @example:
	*	usado no controller Frame_View::get('nome');
	*
	*/
	static function get($name){
		//strict
		return (isset(self::getInstance()->__vars[$name]))?self::getInstance()->__vars[$name] : self::getInstance()->$name;
	}



	/**
	 * Sigleton func
	 */
	static public function getInstance( $class=null )
	{
		return parent::getInstance(get_class());
	}



	//retorna o caminho da camada view
	public function pathView()
	{
		return  FRAME_PATH.'/'.DIR_MODULES_NAME.'/'.ucfirst(self::getInstance()->moduleName).'/View/'.self::getInstance()->format."/";
		//_pathView somente é manipulado setLayout
		if(!self::getInstance()->_pathView)
		 	self::getInstance()->_pathView = FRAME_PATH.'/'.DIR_MODULES_NAME.'/'.ucfirst($this->moduleName).'/View/'.$this->format."/";
		return self::getInstance()->_pathView;
	}

	/*
	* Retorna o caminho da camada VIEW do URS do module passado
	*
	*/
	static function getPathWithModule($moduleName)
	{
		return FRAME_PATH.'/'.DIR_MODULES_NAME.'/'.ucfirst($moduleName).'/View/'.self::getInstance()->format."/";
	}


	//caminho do view
	public function pathViewController()
	{
		return self::getInstance()->pathView().Frame_URS::$controllerName."/";
	}



	//caminho
	public function pathLayout()
	{
		//Frame_Dump::dump(self::getInstance());
		return self::getInstance()->pathView().self::getInstance()->layout;
	}



	//
	public function pathViewControllerAction()
	{
		return self::pathViewController() . Frame_URS::$actionName;
	}


	/**
	 *
	 */
	static public function setFlash($value='', $type='notice')
	{
		Frame_Session::set('flash', $value);
		Frame_Session::set('flashType', $type);
	}




	function __get($name){
		return self::getInstance()->__vars[$name];
	}
	function __set($name , $value){
		self::getInstance()->__vars[$name]=$value;
	}


}