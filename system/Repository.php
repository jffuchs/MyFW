<?php 
	abstract class Repository 
	{
		protected $nome;	
		protected $model;

		//-----------------------------------------------------------------------------------
		public function __construct($nome) 
		{
			$this->nome = $nome;

			//Instancia um objeto pelo nome do controller...
			$nomeClasseModel = $nome.'Model';
			$this->model = new $nomeClasseModel();
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