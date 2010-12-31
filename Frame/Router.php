<?

/*
* Classe com as rotas
* Quando encontrado uma rota, e substitido pelo URS apropriado
*
* o formato eh _routes['regexroute/']= array('controller'=>'nome', 'action'=>'action',  )
* @example:
*	_routes['admin/(.+)/']=array('controller'=>'administrador', 'action'=>'index', params=>'$1' )
*
* A rota é por ordem de indice, 0 = controller, 1 = action, [2..] parametros para a action
*/
class Frame_Router extends Frame_Class{

	static private $_routeFile = '/Config/routers.php';

	//default routes
	static private $_routes = array(
		/*mostra o controller no formato expecificado /format/json/controllername/actionname/parans...*/
		/*'@^\/format\/json(.*)@i'=> array('format'	=> 'json',
											 	  'urs'		=> '$1',
											      '_continue'=>true
											),
		'/^\/format\/xml(.*)/i'=> array('format'	=> 'xml',
											 	  'urs'		=> '$1',
											      '_continue'=>true
											),*/
		/*Action padrao caso não seja definido*/
		'/^(\w+)(\/$|$)/'		=> array( 'controller'	=> '$1',
										  'action'		=> 'index'
										),
		/*Controller e action por defeito "" or "/"*/
		'/^(\/$|$)/'			=> array( 'controller'	=> 'index',
										  'action'		=> 'index'
										)
	);

	/*
	* Monta uma roda
	* @example
	* Frame_Router::set('/regex/', array('controller'=>,'action'=>...))
	*/
	static function set($route, $resource){
		self::$_routes[$route] =  $resource;
	}

	/*
	* Set todas as rotas
	* ver dir Config/routers.php
	*/
	static function setRoutes($routes){
		$oldRoutes = self::$_routes;
		self::$_routes = array();
		foreach ($routes as $route => $resource) {
			self::set($route, $resource);
		}
		foreach ($oldRoutes as $route => $resource) {
			self::set($route, $resource);
		}
	}


	static function addModule($moduleName, $continue=true)
	{
		self::set('/^\/'.$moduleName.'\/{1}(.*)$/i', array('module'=> $moduleName,'_continue'	=> $continue ) );
	}

	static function addFormat($format, $continue=true)
	{
		self::set('@^\/format\/'.$format.'(.*)@i', array('format'=> $format,'urs'=> '$1','_continue'=> true) );
	}


	/*
	* Retorna todas as rotas.
	*/
	static function getRoutes(){

		if(file_exists(FRAME_PATH.self::$_routeFile)){
			include_once FRAME_PATH.self::$_routeFile;
		}
		return self::$_routes;
	}
}