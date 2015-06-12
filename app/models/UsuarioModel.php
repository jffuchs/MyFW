<?php
    class UsuarioModel extends Model
    {
        const NOME = "Usuário";
        const NOME_LISTA = "Usuários";

        //-----------------------------------------------------------------------------------
        public function __construct()
        {
            parent::__construct("usuario");
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
