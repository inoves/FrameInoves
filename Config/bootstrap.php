<?php
/**
* Inicializa todas as configurações
* Podes ter uma pasta Public para o modulo e usar um ficheiro de configModApp.ini para configurar cada modulo separadamente,
*/

// Define environment, preferencialmente defina variavel de ambiente directamente no servidor lighttpd
//setenv.add-environment = ("ENVIRONMENT"=>"staging")
defined('ENVIRONMENT')
    || define('ENVIRONMENT', (getenv('ENVIRONMENT') ? getenv('ENVIRONMENT') : 'development'));


//camada de configuracao, use zen_config
Frame_Config::add( new Zend_Config_Ini(FRAME_PATH.'/Config/config.ini', ENVIRONMENT) );

//define timezone
date_default_timezone_set( Frame_Config::get()->timezone );


//define report error level
error_reporting(E_ALL);


//set errors handlers
set_error_handler( 'Frame_Exception::errorHandler' );
set_exception_handler( 'Frame_Exception::errorHandler' );


//config URS default, podes especificar um modulo em cada pasta public.
Frame_URS::config( Frame_Config::get()->URS );


//set default layout for all module and HTML view
Frame_View::setLayout('layout/default');


