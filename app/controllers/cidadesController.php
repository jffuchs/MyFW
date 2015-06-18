<?php
    class Cidades extends Controller
    {
        //-----------------------------------------------------------------------------------
        public function __construct()
        {
            parent::__construct('cidades', 'Cidades');

            $this->camposEdicao = array("ID", "nome");
            $this->camposPost = array("nome");
            $this->nomeCampoID = 'ID';

            $this->colunas->add('ID', 'ID', 'number', '.col-md-1', "right")
                          ->add('nome', 'Nome', 'text', '.col-md-9')
                          ->add('uf', 'UF', 'text', '.col-md-1')
                          ->add('actions', 'Ações', 'text', '.col-md-1');

            $this->filtros->add('ID', 'ID', '= %d', 'number')
                          ->add('nome', 'Nome', 'LIKE', 'text')
                          ->add('uf', 'UF', 'LIKE', 'text');

            $this->SQL = "SELECT ID, nome, uf
                          FROM cidade
                          INNER JOIN estado ON id_estado = estado";
        }

        //-----------------------------------------------------------------------------------
        public function index_action()
        {
            parent::index_action();
        }
    }
?>
