<?php
/**
 * selectBox($name, $id)
 * 	->setOptions($values, $optionsValues)
 * ->setDefault(defaultValue)
 * ->setClass($className)
 * ->setHtml($html)
 * 
 * @author stevenkoch
 *
 */
class Frame_View_HTML_Helper_SelectBox{
	
	private $_name;
	private $_id;
	
	private $_class;
	private $_html;
	
	private $_options;
	private $_values;
	private $_default;
	
	private $_includeBlank = false;
	
	function __construct($name,$id) {
		$this->_name = $this->_id = $name;
		if($id)
			$this->_id = $id;
		return $this;
	}
	
	public function setHtml($_html) {
		$this->_html = $_html;
		return $this;
	}

	public function setClass($_class) {
		$this->_class = $_class;
		return $this;
	}
	
	public function setDefault($_default) {
		$this->_default = $_default;
		return $this;
	}

	function setOptions($options, $optionsValues=null) {
		$this->_options = $options;
		if($optionsValues)
			$this->_optionsValues = $optionsValues;
		return $this;
	}
	
	function includeBlank($name) {
		$this->_includeBlank=$name;
		return $this;
	}
	
	function __toString() {
		$html = '<select name="'.$this->_name.'" id="'.$this->_id.'"';
		if($this->_class)
			$html .= ' class="'.$this->_class.'" ';
		if($this->_html)
			$html .= ' '.$this->_html.' ';
		$html .= '>';
		if($this->_includeBlank)
			$html .= '<option value="">'.$this->_includeBlank.'</option>';
		if(isset($this->_optionsValues))
			for($i=0;$i<count($this->_options); $i++){
				$html .= '<option value="'.$this->_optionsValues[$i].'" ';
				if($this->_optionsValues[$i]==$this->_default)
					$html .= ' selected="selected" ';
				$html .= '>'.(($this->_options[$i])?$this->_options[$i]:'...indiferente').'</option>';
			}
		else
			foreach($this->_options as $k => $v){
				$html .= '<option value="'.$k.'" ';
				if($k==$this->_default)
					$html .= ' selected="selected" ';
				$html .= '>'.$v.'</option>';
			}
		$html .= '</select>';
		return $html;
	}
}