<?php
	class Index extends Controller
	{
		public function index_action()
		{
			$dados = $this->getParam();
			$this->view("Home", $dados);

            /*if (Session::getFrom('Login','ID') <= 0) {
                Redirect::toPath('usuario/Login');
            }*/
		}
	}
?>
