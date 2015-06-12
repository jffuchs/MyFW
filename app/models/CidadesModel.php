<?php
    class CidadesModel extends Model
    {
        const NOME = "Cidade";
        const NOME_LISTA = "Cidades";

        //-----------------------------------------------------------------------------------
        public function __construct()
        {
            parent::__construct("cidade");
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
