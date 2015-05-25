<?php 
	class Warning 
	{
		public function page404($msg) 
		{
			Session::set('msgErro', array('msg' => $msg));
			require_once(VIEWS.'404.phtml');
		}
	}
?>