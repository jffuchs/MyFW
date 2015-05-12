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
			$dadosCache = $this->getDadosCache();

			$this->setDados($dados, 'Nome', $this->getDados($dados, 'Nome').' - '.$this->getDados($dadosCache, 'Celular'));

			return $dados;
		}

		//-----------------------------------------------------------------------------------
		public function Validar() {
			$dados = $this->setDadosGravacao();

			$id = (int)$this->regPOST("ID");

			$this->antesGravar($dados);

			$ok = $this->model->Salvar($dados, $id); 
			//$ok = FALSE;

			$this->session->addAlerta($ok ? SALVO : NAO_SALVO);	

			if ($ok)
				$this->Redirect($this->indexLocation);
			
			$this->session->setDadosCache($this->getDadosCache());
			$this->redirectInterno($id);			
		}
	}
?>