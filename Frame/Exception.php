<?php
/**
* Handler exception
*/
class Frame_Exception extends Exception
{
	static function errorHandler($errno, $errstr, $errfile, $errline)
	{
		switch ($errno) {
	    	case E_USER_ERROR:
				error_log("WARNING error: $errstr. File: $errfile ,Line: $errline<br />\n", 3, FRAME_PATH.'/Logs/fatal.log' );
		        Frame_Rack::redirect('/errors/500.html');
		        break;
			case E_WARNING:
		    case E_USER_WARNING:
				error_log("WARNING error: $errstr. File: $errfile ,Line: $errline<br />\n", 3, FRAME_PATH.'/Logs/warning.log' );
		        break;

			case E_USER_NOTICE:
			case E_NOTICE:
			case @E_STRICT:
				error_log("NOTICE error: $errstr. File: $errfile ,Line: $errline<br />\n", 3, FRAME_PATH.'/Logs/notice.log' );
		        break;

			case @E_RECOVERABLE_ERROR:
		    default:
				error_log("Unknown error type: [$errno] $errstr. File: $errfile ,Line: $errline<br />\n", 3, FRAME_PATH.'/Logs/error.log' );
		        break;
	    }
	    return true;
	}
}
