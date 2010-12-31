<?php
class Frame_View_HTML_Helper
{

	/**
	 * 
	 * @param string $name
	 * @param string $id
	 */
	function selectBox($name, $id=null) {
		return new Frame_View_HTML_Helper_SelectBox($name, $id);
	}

}