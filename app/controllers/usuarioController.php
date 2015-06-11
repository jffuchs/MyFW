<?php 
    class Usuario extends Controller
    {       
        //-----------------------------------------------------------------------------------
        public function __construct() 
        {
            parent::__construct('usuario');

            $this->camposEdicao = array("ID", "Nome", "Apelido", "Senha", "ADMIN");
            $this->camposPost = array("Nome", "Apelido", "Senha", "ADMIN");
            $this->nomeCampoID = 'ID';
        }       
        
        //-----------------------------------------------------------------------------------
        public function index_action() 
        {
            $this->colunas->add('ID', 'ID', 'number', '.col-md-1', "right")
                          ->add('Nome', 'Nome', 'text', '.col-md-8')
                          ->add('Apelido', 'Apelido', 'text', '.col-md-2')
                          ->add('actions', 'Ações', 'text', '.col-md-1');

            $this->filtros->add('ID', 'ID', '= %d', 'number')
                          ->add('Nome', 'Nome', 'LIKE', 'text')
                          ->add('Apelido', 'Apelido', 'LIKE', 'text');

            parent::index_action();
        }

        public function antesGravar()
        {
            if ($this->dataSet['ADMIN'] == 'on') {
                $this->dataSet['ADMIN'] = 1;
            }
        }

        public function logar()
        {
            $ok = FALSE;            

            $this->dataCache = $this->getDataView();

            $senha = $this->dataCache['Senha'];

            $id = abs(filter_var($this->dataCache['ID'], FILTER_SANITIZE_NUMBER_INT));
            if ($id) {
                $ok = $this->repository->find("ID = $id AND Senha = '$senha'");
            }
            if (!$ok) {
                $apelido = $this->dataCache['ID'];
                $ok = $this->repository->find("Apelido = '$apelido' AND Senha = '$senha'");
            }

            if (!$ok) {
                Alert::set(DADOS_INVALIDOS, "Usuário/Senha não conferem!");
                Redirect::toPath('usuario/logOut');                
            }

            $dados = $this->repository->getRecord("ID = $id AND Senha = '$senha'");
            $dados = $dados[0]; 

var_dump($dados);
//exit;

            Session::setPlus('Login', 'ID', $dados['ID']);
            Session::setPlus('Login', 'Nome', $dados['apelido']);
            Session::setPlus('Login', 'Debug', FALSE);
            Redirect::home();           
        }

        public function logOut() 
        {
            Session::setPlus('Login', 'ID', 0);
            Session::setPlus('Login', 'Nome', '');
            Redirect::toPath('usuario/login');
        }

        public function logIn() 
        {
            $this->camposEdicao = array("ID", "Senha");
            $dados = $this->getDadosEdicao();
            $this->view('usuarioLogin', $dados);
        }

        public function config() 
        {
            if (Session::getFrom('Login', 'Debug')) {
                Session::setPlus('Login', 'Debug', FALSE);
            } else {
                Session::setPlus('Login', 'Debug', TRUE);
            }
            Redirect::to(PATH);
        }       
    }
?>