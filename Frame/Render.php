<?
// Declara a interface 'renderview'
interface Frame_Render
{
	static function setView( Frame_View $view );
	static function getView( );
    static function getInstance();
    public function renderOutput();
	public function __toString();
}
