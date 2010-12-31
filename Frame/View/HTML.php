<?
/*
* Output de View em HTML, geralmente um arquivo com extensão .phtml
*
* Fazer a interface
*/
class Frame_View_HTML extends Frame_Class implements Frame_Render{

	//guarda instancia da camada view
	private $__view;
	
	//extenção usada pela camada de render HTML
	private $__extension = '.phtml';
	
	//guarda dados gerados pela camada HTML
	private $output = '';
	
	//Guarda os partials que ainda faltam renderizar pelo ->partials()
	private $__partialsRemain;
	
	
	public $helper;
	
	
	function __construct( Frame_View $view ) {
		$this->helper = new Frame_View_HTML_Helper();
		$this->setView($view);
	}
	
	
	/**
	 * Setter function
	 * Attribui a camada view ao render HTML
	 *
	 * @param Frame_View $__view
	 * @return void
	 * @author steven koch
	 **/
	static function setView( Frame_View $view )
	{
		self::getInstance()->__view = $view;//guarda referencia
	}
	
	
	/**
	 * Template: $this->flash()
	 */
	public function flash()
	{
		if($flashType = Frame_Session::getAndDel('flashType'))
			return '<p class="'.$flashType.'">'.Frame_Session::getAndDel('flash').'</p>';
	}
	
	
	
	/*
	* Devolve a camada view
	* @return Frame_View $__view
	*/
	static function getView(  )
	{
		return self::getInstance()->__view;
	}
	
	
	
	/**
	 * Change format of frame view
	 *
	 * @return void
	 **/
	function changeFormat($format) {
		self::getInstance()->__view->format = strtoupper($format); 
	}
	
	
	/*
	* Retorna saida 
	* 
	*/
	public function __toString(){
		return $this->output;
	}
	
	
	/**
	 * return output generate by renderOutput
	 *
	 * @return string
	 **/
	public function getOutput(){return $this->output;}
	
	
	/**
	 * set output
	 *
	 * @return string
	 **/
	public function setOutput($_output){$this->output=$_output;}
	
	
	/**
	 * generate by renderOutput
	 *
	 * @return string
	 **/
	public function pathPartial($pathPartial, $module=null)
	{
		return self::getView()->pathView().$pathPartial;
	}
	
	
	/*
	* Render templates via HTML frame
	*
	* $layout é o nome do arquivo que contem o layout html
	* 
	*/
	public function renderOutput(){
		//if($this->output) return $this->output;
		ob_start();
		if ( !Frame_View::disabledLayout() ){
			//layout
			require (strstr( $this->__extension, self::getView()->pathLayout()))? self::getView()->pathLayout() : self::getView()->pathLayout() . $this->__extension;
		}else{
			$this->contentAction();//only action
		}
		$this->output .= ob_get_clean();
		return $this->output;
	}
	
	
	/**
	 * Retorna conteudo do template action
	 */
	public function contentAction(){
		echo "\n<!-- ".date('D, d M Y H:i:s')." @contentAction -->\n";
		require self::getView()->pathViewControllerAction(). $this->__extension;
	}
	
	
	/**
	 * Retorna o conteúdo partial
	 * @example
	 * //from root View folder
	 * $this->partial(''elements/headers/header.phtml'');
	 */
	public function partial($pathPartial, $module=null){
		echo "\n<!-- ".date('D, d M Y H:i:s').' @'.$pathPartial." -->\n";
		require $this->pathPartial($pathPartial);
	}
	

	/**
	* Include recursive partials
	* inclue recusivamente templates partials
	* @example:
	* //insere um boxMain e dentro da boxMain um boxDetail
	*	$this->partials('elements/boxMain.phtml', 'elements/boxDetail.phtml')
	* 	//Inside of partial file insert <?php $this->partials() ?>, this insert next partial
	* boxMain.phtml
	*	<div><h3>Box Main</h3><?php $this->partials() ?></div>
	* boxDetail.phtml
	*	<div>Details of box...</div>
	*/
	public function partials(){
		$recursivePartials = func_get_args();
		if($recursivePartials==null && $this->__partialsRemain)
			$recursivePartials = $this->__partialsRemain;
		
		if(is_array($recursivePartials)){
			$currentPartial = array_shift($recursivePartials);
			$this->__partialsRemain = $recursivePartials;
		}
		if($currentPartial)
			$this->partial($currentPartial);
	}
	
	
	/**
	 * Verifica se existe o ficheiro partial
	 */
	public function ifExists($path)
	{
		return file_exists($this->pathPartial($path));
	}
	
	/**
	 * Retorna o conteúdo partial
	 */
	public function partialIfExists($pathPartial, $module=null){
		$p = $this->pathPartial($pathPartial);
		if(!file_exists($p))
			return false;
			
		require $p;
		
		return true;
	}
	
	
	
	
	//dentro dos templates HTML é acedido as variaveis do objecto View
	function __get($name){
		return self::getView()->get($name);
	}
	function __set($name , $value){
		return self::getView()->set($name, $value);
	}
	
	
	
	//retorna referencia
	public static function getInstance($class=null)
	{
		return parent::getInstance(get_class());
	}
	
	
}