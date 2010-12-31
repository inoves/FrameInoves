<?php
/**
*
*/
class Plugin_Xdebug
{
	//Set profiler
	function beforeRunModuleApp()
	{
		if(ENVIRONMENT=='development'){
			//Frame_Connect::getConMysql()->debug=true;
			//setcookie('XDEBUG_PROFILE', 1, 0,'/');
		

			if( isset($_REQUEST['xdebug']) && $_REQUEST['xdebug']==true ){				ini_set('xdebug.collect_vars', 'on');
				ini_set('xdebug.collect_params', '4');
				ini_set('xdebug.dump_globals', 'on');
				ini_set('xdebug.dump.SERVER', 'REQUEST_URI');
				ini_set('xdebug.show_local_vars', 'on');
			}
		
		}else{
			//error_reporting(0);
			xdebug_disable();
		}
	}
}
