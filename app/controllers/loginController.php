<?php
    class Login extends Controller
    {
        //-----------------------------------------------------------------------------------
        public function __construct()
        {
            parent::__construct('usuario');

            $this->camposEdicao = array("ID", "Senha");
            $this->nomeCampoID = 'ID';
        }

        //-----------------------------------------------------------------------------------
        public function index_action()
        {
            if (Session::getFrom('Login', 'ID') <= 0) {
                $this->camposEdicao = array("ID", "Senha");
                $dados = $this->getDadosEdicao();
                $this->view('usuarioLogin', $dados);
            } else {
                Redirect::home();
            }
        }

        public function logar()
        {
            $ok = FALSE;
            $where = '';

            $this->dataCache = $this->getDataView();

            $senha = $this->dataCache['Senha'];

            $id = abs(filter_var($this->dataCache['ID'], FILTER_SANITIZE_NUMBER_INT));
            if ($id) {
                $where = "ID = $id AND Senha = '$senha'";
                $ok = $this->repository->find($where);
            }
            if (!$ok) {
                $apelido = $this->dataCache['ID'];
                $where = "Apelido = '$apelido' AND Senha = '$senha'";
                $ok = $this->repository->find($where);
            }

            if (!$ok) {
                Alert::set(DADOS_INVALIDOS, "Usuário/Senha não conferem!");
                Redirect::toPath('usuario/logOut');
            }

            $dados = $this->repository->getRecord($where);
            $dados = $dados[0];

            Session::setPlus('Login', 'ID', $dados['ID']);
            Session::setPlus('Login', 'Nome', $dados['Nome']);
            Session::setPlus('Login', 'Apelido', $dados['Apelido']);
            Session::setPlus('Login', 'ADMIN', $dados['ADMIN']);
            Session::setPlus('Login', 'Debug', FALSE);
            Redirect::home();
        }

        public function out()
        {
            Session::setPlus('Login', 'ID', 0);
            Session::setPlus('Login', 'Nome', '');
            Session::setPlus('Login', 'ADMIN', 0);
            Redirect::toPath('usuario/login');
        }
    }
?>
