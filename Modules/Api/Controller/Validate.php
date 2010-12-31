<?
/**
*
* App_Controller_Index - indexAction
*/
class Api_Controller_Validate extends Frame_Controller
{
	
	
	/**
	 * Get categories of root
	 */
	public function isFloatAction($locale, $number)
	{
		try{
			$number = urldecode($number);
			$number = str_replace(' ', '', $number);
			$response = Zend_Locale_Format::isNumber($number, array('locale' => $locale));
			Frame_View::set('number', $number);
			Frame_View::set('locale', $locale);
			Frame_View::set('response', $response);
			Frame_View::set('float', Zend_Locale_Format::getNumber($number, array('locale' => $locale)));
		} catch (Exception $e){
			Frame_View::set( 'response', false );
			Frame_View::set( 'exception', $e->getMessage() );
		}
	}
	
	
}