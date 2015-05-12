<?php
	class FornecedoresModel extends Model 
	{
		const NOME = "Fornecedor";
		const NOME_LISTA = "Fornecedores";

		//-----------------------------------------------------------------------------------
		public function __construct() {
			parent::__construct("fornecedor");	
		}

		//-----------------------------------------------------------------------------------
		public function Lista($id = NULL) {
			return $this->read(isset($id) ? "ID = $id" : NULL);
		}

		//-----------------------------------------------------------------------------------
		public function Salvar($dados, $id = 0) {	
			if ($id > 0)
				return $this->Update($dados, "ID = $id");
			else
				return $this->Insert($dados);
		}
	}
?>