<?php 
    class Cidades extends Controller
    {       
        //-----------------------------------------------------------------------------------
        public function __construct() 
        {
            parent::__construct('cidades');

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

            $this->setOrderBy('Nome');

            parent::index_action();
        }   
    }
?>