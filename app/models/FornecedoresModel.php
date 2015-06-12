<?php
	class FornecedoresModel extends Model
	{
		const NOME = "Fornecedor";
		const NOME_LISTA = "Fornecedores";

		//-----------------------------------------------------------------------------------
		public function __construct()
		{
			parent::__construct("fornecedor");
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
