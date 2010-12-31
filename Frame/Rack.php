<?
/**
*
* Cria/reencaminha/redirecciona recursos
*
* Rack executa o recurso em um determinado local
*
* Rack mostra na tela o output
*
* Rack faz cache
*
*
*/
class Frame_Rack extends Frame_Class
{



	//desactiva layout global, acho que eh o viw quem tem que cuidar disso
	static public $disableLayout = false;



	//desactiva conteudo da action, acho que eh o view quem tem que cuidar disso
	static public $disableOutput = false;



	//qual objecto deve cuidar do output?
	static public $format = 'HTML';



	static private $_formatSupported = array('HTML', 'JSON', 'XML');


	static public $results = array();

	/**
	 * A criação de deste rack em de um reencaminhamento interno?
	 * É usado para informar ao rack não executar de novo alguns metodos
	 */
	static private $_disableNextRun = false;



	//URS
	static private $_resource;
	static private $_originalResource;


	//before e after
	static private $_plugins = array();



	static function setPluginPre($name, $object)
	{
		self::setPlugin($name, $object, 'pre');
	}


	static function setPluginPost($name, $object)
	{
		self::setPlugin($name, $object, 'post');
	}


	static function setPlugin($name, $object, $_type='pre'){
		self::$_plugins[$_type][] = $object;
	}



	static function setFormat($format)
	{
		self::$format = $format;
	}



	/*
	* Redirecciona para URL
	*/
	static function redirect($url, $exit=true)
	{
		header("Location:".$url);
		if($exit) exit(0);
	}



	/*
	* Reencaminha para um recurso
	*/
	static function forward($actionName, $controllerName=null, $moduleName=null)
	{
		$_urs = self::$_resource;
		if($moduleName)
			Frame_URS::$moduleName = $moduleName;
		if($controllerName)
			Frame_URS::$controllerName = $controllerName;

		Frame_URS::$actionName = $actionName;

		self::run( $_urs );

		self::$_disableNextRun = true;
	}

	/*
	* Retorna o URS actual, que esta chamando o controller e action
	*/
	static function	getURS()
	{
		return self::$_resource;
	}

	/**/
	static function getResult($name=null)
	{
		if(!$name)
			$name =  self::$_resource->actionName.'Action';
		return self::$results[$name];
	}


	/*
	* Retorna o URS original, criado pelo index.php
	*/
	static function	getOriginalURS()
	{
		return self::$_originalResource;
	}


	/*
	* Executa URS, $fromIndex é definido somente quando o RACK é executado pela framework, nunca deve ser definido pelo utilizador
	*
	*/
	static function run( Frame_URS &$resource, $fromIndex = false )
	{

		if($fromIndex)
			self::$_originalResource=$resource;
		self::$_resource = $resource;
		//vincula um URS ao VIEW
		Frame_View::setURS( $resource );

		//se não tem um resource carrega plugins
		if($fromIndex)
		{
			self::chargedPlugins();
			foreach (self::$_plugins as $keyName => $pluginObj)
			{
				//beforeRun all modules
				if(method_exists($pluginObj, 'beforeRun'))
					$pluginObj->beforeRun( $resource );

				//beforeRunModuleXXX
				if(method_exists($pluginObj, 'beforeRunModule'.Frame_URS::$moduleName))
				{
					$run = 'beforeRunModule'.Frame_URS::$moduleName;
					$pluginObj->$run( $resource );
				}

			}
		}

		if(!self::$_disableNextRun){
			self::$_disableNextRun=false;

			//controller
			$controllerName = ucfirst(Frame_URS::$moduleName)."_Controller_".ucfirst(Frame_URS::$controllerName);
			if(!class_exists($controllerName, true))
				throw new Frame_Exception_NotFound('Not found '.$controllerName, 404);

			$controllerObject = new $controllerName;

			//executa beforeRun controller
			if( method_exists($controllerObject, 'beforeRun') )
			 self::$results['beforeRun'] = @call_user_func_array(array($controllerObject, 'beforeRun'), Frame_URS::$params);


			//executar Action
			$actionName = Frame_URS::$actionName."Action";

			if( method_exists($controllerObject, $actionName) ){
				self::$results['action'] = @call_user_func_array( array($controllerObject, $actionName), Frame_URS::$params);
			}else{
				throw new Frame_Exception_NotFound('Not found '.$controllerName.'-'.$actionName, 404);
			}

			//afterRun controller
			if( method_exists($controllerObject, 'afterRun') )
			 self::$results['afterRun'] = @call_user_func_array(array($controllerObject, 'afterRun'), Frame_URS::$params);
		}else{
			self::$_disableNextRun=false;
			return;
		}


		//se não tem um resource carrega plugins, isso porque veio pelo dispatch
		if($fromIndex)
		{
			foreach (self::$_plugins as $keyName => $pluginObj){
				if(method_exists($pluginObj, 'afterRun'))
					$pluginObj->afterRun();
			}
		}

		//se não ha camada de renderizacao
		if (!in_array( Frame_URS::$format, Frame_View::$formatSupported))
			throw new Frame_Exception(Frame_URS::$format. '::Format not supported.');

		//camada de renderizacao da view
		$classRender = "Frame_View_".strtoupper( Frame_URS::$format );
		$objectRender = new $classRender(  Frame_View::getInstance() );
		//$objectRender->setView( Frame_View::getInstance() );

		//filtro q trata dos dados antes de imprimir
		foreach (self::$_plugins as $keyName => $pluginObj){
			if(method_exists($pluginObj, 'beforePrint'))
				$pluginObj->beforeRender(&$objectRender);
		}

		//processa a saida da camada de renderizacao da view
		$objectRender->renderOutput();


		foreach (self::$_plugins as $keyName => $pluginObj){
			if(method_exists($pluginObj, 'afterPrint'))
				$pluginObj->afterRender(&$objectRender);
		}

		//mostra os dados da camada de renderizacao
		if(!self::$_disableNextRun)
			echo $objectRender;
	}



	/**
	* Actions plugins, Class plugin devem chamar-se Plugin_NomePlugin Arquivo: NomePlugin.php
	* beforeRun, afterRun
	* beforePrint, afterPrint
	*/
	//carrega filtro
	static function chargedPlugins()
	{
		foreach (new DirectoryIterator(FRAME_PATH."/Plugin") as $file)
		{
			//if($file->isDot()) continue;
			if ($file->isFile()){
				//echo ".....". $file->getBasename('.php');
				$className = "Plugin_".$file->getBasename('.php');
				self::$_plugins[$className] = new $className;
			}
		}
	}


}
