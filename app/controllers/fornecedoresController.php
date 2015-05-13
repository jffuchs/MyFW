<?php 
	class Fornecedores extends Controller
	{		
		public function __construct() {
			parent::__construct('fornecedores');

			$this->camposEdicao = array("ID", "Nome", "Celular");
			$this->camposPost = array("Nome");
		}		
		
		//-----------------------------------------------------------------------------------
		public function Index_Action() {
			$this->model->setColunas(array("ID" => "ID", "Nome" => "Nome", "actions" => "Ações"));
			$this->model->setFiltros(array(array("ID", "ID", "= %d", "number"),
				          		           array("Nome", "Nome", "LIKE", "text")));
			parent::Index_Action();
		}	

		//-----------------------------------------------------------------------------------		
		public function antesGravar(&$dados) {
			$this->dataSet['Nome'] = $this->dataCache['Nome'].' - '.$this->dataCache['Celular'];
			return $dados;
		}

		//-----------------------------------------------------------------------------------		
		public function validar() {
			if (strlen($this->dataCache['Celular']) >= 8) {
				return TRUE;
			} 
			$this->session->addAlerta(NAO_SALVO, "Celular precisa ter pelo menos 8 dígitos!");
			return FALSE;
		}		
	}
?>