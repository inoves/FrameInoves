<?php


/**
* Uniform Resource System
* Representa um recurso do sistema
* Cria uma URS a partir de uma URI passada, geralmente vindo de $_SERVER['REQUEST_URI']
* Este objecto server para instanciar um controller e executar uma action de um determinado modulo
*/
class Frame_URS extends Frame_Class
{
	//modulo que urs aponta
	static public $moduleName			= 'App';
	//nome do controller que sera despachado
	static public $controllerName		= 'index';
	//nome da action que urs aponta
	static public $actionName			= 'index';
	//parametros
	static public $params				= array();
	//
	static public $format				= 'HTML';

	static public $get					= array();

	//Uniform Resource System
	public $URS = '';

	//created_on
	private $_created_on;
	private $_idClass;
	//
	public $requestId;

	/**
	 * Config URS
	 * Podes querer que uma pasta PUBLIC especifica use um modulo especifico
	 */
	static public function config($config)
	{
		self::$moduleName = $config->moduleName;
	}


	//construtor
	function __construct($URI=null)
	{
		self::$format = Frame_View::$defaultFormat;
		if(is_array($URI)){//array(module, controller, action, param1, param2, parametc..)
			$this->configDispatch( $this->translateRoute(implode('/',$URI)) );
		}elseif($URI){
			//traduz
			$this->configDispatch( $this->translateRoute($URI) );
		}//senão houver um URI eh porque ja vem configurado

		$this->_created_on = time();
		$this->_idClass 	= uniqid();
	}

	//setter function, controller name
	static function setControllerName($value='')
	{
		self::$controllerName=$value;
	}

	//setter function, action name
	static function setActionName($value='')
	{
		self::$actionName=$value;
	}

	//setter function, action name
	static function setTemplateAction($value='')
	{
		self::$actionName=$value;
	}

	//divide URI
	function splitURI($URI)
	{
		return explode("/", $URI);
	}

	//getter function
	function getCreatedOn()
	{
		return $this->_created_on;
	}

	//getter function
	function getIdClass()
	{
		return $this->_idClass;
	}


	//depois de a ter sido traduzido as rotas, é exec o configDispatch(), dividindo o URI nos componentes
	function configDispatch($URI)
	{
		if(0===($pos = strpos($URI, '/')))
			$URI = substr($URI, 1);
		$paramsURS = explode('/', $URI);
		$controller = array_shift($paramsURS);
		if($controller)
		self::$controllerName = ucfirst( strtolower($controller) );
		$action = array_shift($paramsURS);
		if($action)
		self::$actionName = strtolower($action);
		self::$params = $paramsURS;
	}


	function getMethod() {
		return $_SERVER['REQUEST_METHOD'];
	}

	/*
	* Retorna a URS para a URI passado
	*/
	function translateRoute($URI)
	{
		$_continue = false;
		list($URI, $query) = explode('?', $URI);
		//$URI = $parse['path'];
		parse_str(@$query, self::$get);
		foreach (Frame_Router::getRoutes() as $regxURI => $route){
			$count = 0;

			//@todo refactorar
			if(preg_match( $regxURI, $URI, $m)){
                //var_dump(FRAME_URS::$moduleName);
			    if(isset($route['_continue'])){
					$_continue = $route['_continue'];
					unset($route['_continue']);
				}

				if(isset($route['module'])){
				    //echo $regxURI.'<br>';
					FRAME_URS::$moduleName = $route['module'];
					unset($route['module']);
					$URI = $m[1];

				}

				if(isset($route['format'])){
					if(in_array(strtoupper($route['format']), Frame_View::$formatSupported)){
						self::$format = strtoupper($route['format']);
					}else{
						throw new Frame_Exception($route['format']. ': Format not supported.');
					}
					unset($route['format']);
				}

				$URI = preg_replace( $regxURI, join('/', $route), $URI, 1, $count );

				if( $count > 0 && !$_continue )
					return $URI;
				//$_continue = false;
			}
		}
		return $URI;
	}

	static public function get($name) {
		return self::$get[$name];
	}

}