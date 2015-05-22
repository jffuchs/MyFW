<?php 
	class Warning 
	{
		public function page404($msg) 
		{
			$dados['msg'] = [$msg];
			Session::set('msgErro', $dados['msg']);
			require_once(VIEWS.'404.phtml');
		}
	}
?>