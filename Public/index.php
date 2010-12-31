<?
/**
* Framework FRAME
* Uma framework modular, mcv, orientado a agilidade, organização e padronização do codigo.
* Para saber como funciona a estrutura de pastas, ler README.
*
*
* Desenvolvido por inov.es <info@inov.es>
*
*
*/

// Define path to root Frame directory
defined('FRAME_PATH')
    || define('FRAME_PATH', realpath(dirname(__FILE__) . '/../'));


defined('DIR_MODULES_NAME')
    || define('DIR_MODULES_NAME', 'Modules');
defined('DIR_MODELS_NAME')
    || define('DIR_MODELS_NAME', 'Model');
defined('DIR_LIB_NAME')
    || define('DIR_LIB_NAME', 'Lib');
defined('DIR_PLUGIN_NAME')
    || define('DIR_PLUGIN_NAME', 'Lib');

//include paths
set_include_path(/*get_include_path().
				  PATH_SEPARATOR.*/
 				  FRAME_PATH.
				  PATH_SEPARATOR.
				  FRAME_PATH.'/'.DIR_MODULES_NAME.'/'.
				  PATH_SEPARATOR.
				  FRAME_PATH.'/'.DIR_MODELS_NAME.'/'.
				  PATH_SEPARATOR.
				  FRAME_PATH.'/'.DIR_LIB_NAME.'/'.
				  PATH_SEPARATOR.
				  FRAME_PATH.'/'.DIR_PLUGIN_NAME.'/');


//Autoload
include(FRAME_PATH.'/Frame/Loader.php');
//add stack autoloads functions @todo
$autoload = new Frame_Loader();



//O objectivo diminuir ao maximo a necessidade de aceder/alterar Public/index.php
//ficheiro de inicialização padrão das configurações, cada pasta publica(frontend, backoffice, webservices) que compartilham o mesmos models e library iniciam um intconfig.php diferente
//if(file_exists(FRAME_PATH.'/Config/BootstrapModApp.php'))
include FRAME_PATH.'/Config/bootstrap.php';



//create Uniform Resource System
$urs = new Frame_URS($_SERVER['REQUEST_URI']);


// GO!
try
{
	//Cria um novo rack de execução para o resource identificado em URI
	Frame_Rack::run( $urs , true);
}
catch (Frame_Exception_NotFound $e)
{
	if(Frame_Config::get()->error->notFound)
	{
		Frame_Rack::redirect( Frame_Config::get()->error->notFound.'?url=http://'.urlencode($_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]) );
	}
	else
	{
		echo '<html><head><title>Error, not found</title></head><body><h1>Not found</h1></body></html>';
	}
}
catch (Exception $e)
{
	//exception
	if(Frame_Config::get()->error->internal)
	{
		Frame_Rack::redirect(Frame_Config::get()->error->internal);
	}
	else
	{
		echo '<html><head><title>Internal Server Error</title></head><body><h1>Internal Server Error</h1></body></html>';
	}
}