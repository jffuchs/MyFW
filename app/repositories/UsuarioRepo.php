<?php 
    class UsuarioRepo extends Repository
    {
        //-----------------------------------------------------------------------------------
        public function __construct($nome) 
        {
            parent::__construct($nome);
        }

        //-----------------------------------------------------------------------------------
        public function lista($id = NULL) 
        {
            return $this->model->read(NULL, isset($id) ? "ID = $id" : NULL);
        }

        //-----------------------------------------------------------------------------------
        public function salvar($dados, $id = 0) 
        {
            return $this->model->salvar($dados, $id);
        }
    }
?>