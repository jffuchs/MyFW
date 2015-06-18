<?php
    class Usuario extends Controller
    {
        //-----------------------------------------------------------------------------------
        public function __construct()
        {
            parent::__construct('usuario', 'Usuario');

            $this->camposEdicao = array("ID", "Nome", "Apelido", "Senha", "ADMIN");
            $this->camposPost = array("Nome", "Apelido", "Senha", "ADMIN");
            $this->nomeCampoID = 'ID';

            $this->colunas->add('ID', 'ID', 'number', '.col-md-1', "right")
                          ->add('Nome', 'Nome', 'text', '.col-md-8')
                          ->add('Apelido', 'Apelido', 'text', '.col-md-2')
                          ->add('actions', 'Ações', 'text', '.col-md-1');

            $this->filtros->add('ID', 'ID', '= %d', 'number')
                          ->add('Nome', 'Nome', 'LIKE', 'text')
                          ->add('Apelido', 'Apelido', 'LIKE', 'text');
        }

        //-----------------------------------------------------------------------------------
        public function index_action()
        {
            parent::index_action();
        }

        public function antesGravar()
        {
            if ($this->dataSet['ADMIN'] == 'on') {
                $this->dataSet['ADMIN'] = 1;
            }
        }
    }
?>
