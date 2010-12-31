<?php
/*
ao definir um array: Sempre em ordem: module/controller/action/params
Pode omitir o module, assimusara o default
*/
/*'/^home/'
	=> array(	'controller'	=> 'home',
				'action'		=> 'index'
			),
'/^not_found/'
	=> array(	'controller'	=> 'home',
				'action'		=> 'not_found'
			),
'/^page\/(.+)/'
	=> array(	'controller'	=> 'home',
				'action'		=> 'page',
				'id'			=> '${1}'
			),
'/^menu/'
	=> array(	'controller'	=> 'home',
				'action'		=> 'menu'
			),
'/^search/'
	=> array(	'controller'	=> 'home',
				'action'		=> 'search'
			),
'/^lang/'
	=> array(	'controller'	=> 'home',
				'action'		=> 'lang'
			),*/
	/*formats*/

	//habilita formatos
    Frame_Router::addFormat('json');
    Frame_Router::addFormat('mobile');
	Frame_Router::addFormat('xml');
	
	//Frame_Router::set('^\/json(?:.*)/', array('format'=>'json','_continue'=>true));
	/*modules*/
	
	Frame_Router::addModule('admin');
	Frame_Router::addModule('api');
	//'/^\/'.$moduleName.'\/{0,1}(.*)$/i'


	//Frame_Router::set('/(?:category)\/(?:.+)\/(?:.+)/', array('controller'=>'index','action'=>'index', 'menu'=>'${1}', 'submenu'=>'${2}'));
	//Frame_Router::set('/^\/category\/(.*)/i', array('controller'=>'index','action'=>'category', 'id'=>'$1'));

	//Frame_Router::set('/^\/ad\/(.*)/i', array('controller'=>'index','action'=>'$1'));
	//Frame_Router::set('/^\/me\/logout/i', array('controller'=>'index','action'=>'logout'));

	//Frame_Router::set('/^\/ad\/new/i', array('controller'=>'index','action'=>'select'));

	//Frame_Router::set('/^\/api\/format\/json\/(?:.+)$/i', array('module'=>'api','format'=>'json','controller'=>'$1'));
	//Frame_Router::set('/^\/api\/format\/xml\/(?:.+)$/i', array('module'=>'api','format'=>'xml','controller'=>'$1'));


	//Equivalente a adicionar um modulo, o modulo padrao é app
	/*Frame_Router::setRoutes(array(
		//Adiciona um modulo, o modulo padrao é app
		'/^\/admin\/{0,1}(.*)$/i'	=> array(
							'module'		=> 'admin',
							'_continue'	=> true //continua com a procura do padrao
							)
	));*/
