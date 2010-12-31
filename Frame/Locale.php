<?
/**
* @example
*	Frame_Locale::setLocale('Europe/Lisbon')
*/
class Frame_Locale
{
	static $defaultLocale = null;
	
	static function setLocale($value=null)
	{
		if($value==null)
			$value = new Zend_Locale( Zend_Locale::BROWSER );
		setlocale(LC_ALL, $value);
		return self::$defaultLocale = new Zend_Locale($value);
	}
	
	static function get(){
		if (self::$defaultLocale==null){
			self::setLocale();
		}
		return self::$defaultLocale;
	}
	
	static function formatMoney($number, $locale=null)
	{
		$currency = new Zend_Currency($locale);
		return $currency->toCurrency($number);
	}
}
