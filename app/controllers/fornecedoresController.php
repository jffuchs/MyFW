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

			$this->colunas->add('ID', 'ID', 'number', '.col-md-1')
						  ->add('Nome', 'Nome', 'text', '.col-md-10')
						  ->add('actions', 'Ações', 'text', '.col-md-1');

			$this->filtros->add('ID', 'ID', '= %d', 'number')
						  ->add('Nome', 'Nome', 'LIKE', 'text');

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