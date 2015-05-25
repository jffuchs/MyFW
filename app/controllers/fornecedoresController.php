<?php 
	class Fornecedores extends Controller
	{		
		//-----------------------------------------------------------------------------------
		public function __construct() 
		{
			parent::__construct('fornecedores');

			$this->camposEdicao = array("ID", "Nome", "Celular");
			$this->camposPost = array("Nome");
		}		
		
		//-----------------------------------------------------------------------------------
		public function index_action() 
		{
			$this->repository->model->setColunas(array("ID" => "ID", "Nome" => "Nome", "actions" => "Ações"));
			$this->repository->model->setFiltros(array(array("ID", "ID", "= %d", "number"),
				          		           			   array("Nome", "Nome", "LIKE", "text")));
			parent::index_action();
		}	

		//-----------------------------------------------------------------------------------		
		public function antesGravar(&$dados) 
		{
			$this->dataSet['Nome'] = $this->dataCache['Nome'].'-'.$this->dataCache['Celular'];
			return $dados;
		}

		//-----------------------------------------------------------------------------------		
		public function validar() 
		{
			if (strlen($this->dataCache['Celular']) >= 8) {
				return TRUE;
			}
			Alert::set(NAO_SALVO, "Celular precisa ter pelo menos 8 dígitos!");
			return FALSE;
		}		
	}
?>