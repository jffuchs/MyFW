<?php
    class UsuariosModel extends Model 
    {
        const NOME = "Usuário";
        const NOME_LISTA = "Usuários";

        //-----------------------------------------------------------------------------------
        public function __construct() 
        {
            parent::__construct("usuario");  
        }

        //-----------------------------------------------------------------------------------
        public function lista($id = NULL) 
        {
            return $this->read(NULL, isset($id) ? "ID = $id" : NULL);
        }

        //-----------------------------------------------------------------------------------
        public function salvar($dados, $id = 0) 
        {   
            if ($id > 0) {
                return $this->update($dados, "ID = $id");
            } else {
                return $this->insert($dados);
            }
        }
    }
?>