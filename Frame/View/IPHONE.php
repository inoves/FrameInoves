<?php
/*
* Output de View em HTML, geralmente um arquivo com extensão .phtml
*
* Fazer a interface
*/
class Frame_View_IPHONE extends Frame_View_MOBILE{

	function __construct( Frame_View $view ) {
		parent::__construct($view);
		//se quiser actualizar formato para um ja existente e usar os templates da camada do formato
		$this->changeFormat('MOBILE');
	}
}