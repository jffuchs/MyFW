<?php 
    class Usuarios extends Controller
    {       
        //-----------------------------------------------------------------------------------
        public function __construct() 
        {
            parent::__construct('usuarios');

            $this->camposEdicao = array("id", "nome");
            $this->camposPost = array("nome");
            $this->nomeCampoID = 'id';
        }       
        
        //-----------------------------------------------------------------------------------
        public function index_action() 
        {
            $this->colunas->add('id', 'ID', 'number', '.col-md-1', "right")
                          ->add('nome', 'Nome', 'text', '.col-md-9')
                          ->add('estado', 'UF', 'text', '.col-md-1')
                          ->add('actions', 'Ações', 'text', '.col-md-1');

            $this->filtros->add('id', 'ID', '= %d', 'number')
                          ->add('nome', 'Nome', 'LIKE', 'text');

            parent::index_action();
        }   

        public function logOut() 
        {
            Session::destroy();

            Redirect::to(PATH);
        }

        public function config() 
        {
            if (Session::getFrom('Login', 'Debug')) {
                Session::setAdd('Login', 'Debug', FALSE);
            } else {
                Session::setAdd('Login', 'Debug', TRUE);
            }
            Redirect::to(PATH);
        }
    }
?>