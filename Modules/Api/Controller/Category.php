<?
/**
*
* App_Controller_Index - indexAction
*/
class Api_Controller_Category extends Frame_Controller
{
	
	/**
	 * Get categories of root
	 * Retorna todas as categorias raizes.
	 */
	public function indexAction()
	{
		$category = new Model_Category();
		$category->load('slug=?', array($catSlug));
		if(Frame_URS::get('lang'))
			$categories = $category->Find('parent_id=0 AND (lang=? OR lang=\'*\') ORDER BY ord', array(Frame_URS::get('lang')));
		else
			$categories = $category->Find('parent_id=0 AND  (lang=\'en\' OR lang=\'*\')  ORDER BY ord');
		return Frame_View::set('categories', $categories->toArray());
	}
	
	
	/**
	 * Retorna todas as subcategorias da categoria passada.
	 */
	public function getChildsAction($catSlug)
	{
		$category = new Model_Category();
		$category->load('slug=?', array($catSlug));
		if(Frame_URS::get('lang'))
			$categories = $category->Find('parent_id=? AND  (lang=? OR lang=\'*\')  ORDER BY ord', array($category->id,Frame_URS::get('lang')));
		else
			$categories = $category->Find('parent_id=? AND  (lang=\'en\' OR lang=\'*\')  ORDER BY ord', array($category->id));
		return Frame_View::set('categories', $categories->toArray());
	}
	
	
	
}