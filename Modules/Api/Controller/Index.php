<?
/**
* App_Controller_Index - indexAction
* tudo oque é inserido na camada VIEW é enviado via FORMATO(JSON/XML)
*/
class Api_Controller_Index extends Frame_Controller
{

	public function indexAction()
	{
		Frame_View::set('Category', array('index','getChilds'));
		Frame_View::set('Validate', array('isFloat', 'isEmail'));
	}


	public function allAction($page=1)
    {
        Frame_View::set('result', array('teste','teste2'));
    }


}