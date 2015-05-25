<?php 
	abstract class Repository 
	{
		protected $nome;	
		public $model;

		//-----------------------------------------------------------------------------------
		public function __construct($nome) 
		{
			$this->nome = $nome;
			$this->loadModel();
		}

		//-----------------------------------------------------------------------------------
		private function loadModel() {
			$model_path = MODELS.$this->nome.'Model.php';
			
			if (!file_exists($model_path)) {				
				Warning::page404("Arquivo de modelo <b>{$model_path}</b> não encontrado!");
				exit;
			}			
			$nomeClasseModel = $this->nome.'Model';
			$this->model = new $nomeClasseModel();
		}
		
		//-----------------------------------------------------------------------------------
		public function find($where) 
		{
			return count($this->model->read($where)) > 0;
		}

		//-----------------------------------------------------------------------------------
		public function excluir($id)
		{
			return $this->model->delete("ID = $id");
		}

		/*public abstract function validaCadastrar();

		public function cadastrar($objeto)
		{
			if($this->validaCadastrar($objeto))
			{
				return $this->model->salvar($objeto); 
			}
		}

		public function alterar($input,$id)
		{
			$this->model->salvar($input, $id); 
		}

		public function loadFromArray($input)
		{
			foreach ($input as $chave => $valor)
			{
				$chave = 'set' . $chave; // setCampo
				$this->model->$chave($valor);
			}
		}*/
	}
?>