<?php 
	class Warning 
	{
		public function page404($msg) 
		{
			Session::set('msgErro', array('msg' => $msg));
			Redirect::add(VIEWS, '404.phtml');
			Redirect::add(VIEWS, 'footer.phtml');
		}
	}
?>