<?php
	class Controller extends System
	{
		protected $nome;
		protected $model;
		protected $indexLocation;
		protected $editLocation;
		protected $insertLocation;
		protected $camposEdicao;
		protected $camposPost;
		protected $pagina;
		protected $prefixView;
		protected $nomeRegForm;
		protected $dataCache;		//dados que vem do POST
		protected $dataSet;			//dados que irão para o BD

		//-----------------------------------------------------------------------------------
		public function __construct($nome = NULL) {
			parent::__construct();

			if (isset($nome)) {
				$this->setNome($nome);
			}

			$this->prefixView = 'view';
			$this->nomeRegForm = 'RegForm';
		}		

		//-----------------------------------------------------------------------------------
		protected function setNome($nome) {
			$this->nome = $nome;

			$this->indexLocation = PATH.$nome;
			$this->editLocation = PATH.$nome.'/editar/id/';
			$this->insertLocation = PATH.$nome.'/incluir';

			define('CONTROLLER_EDICAO', $nome.'Incluir');

			//Instancia um objeto pelo nome do controller...
			$nomeClasseModel = $nome.'Model';
			$this->model = new $nomeClasseModel();
		}

		//-----------------------------------------------------------------------------------
		protected function getPagina() {
			$pag = $this->getParam("pag");
			if ($pag < 1 or empty($pag))
				$pag = 1;	
			return $pag;
		}

		//-----------------------------------------------------------------------------------
		public function Index_Action() {
			$this->session->setDadosCache(NULL);

			$pagina = new PaginaLista($this->model);
			$pagina->setPaginaAtual($this->getPagina());
			$pagina->setNomeController($this->indexLocation);
			$pagina->show();
		}

		//-----------------------------------------------------------------------------------
		protected function View($nome, $vars = NULL) {
			if (is_array($vars) && count($vars) > 0) {
				extract($vars, EXTR_PREFIX_ALL, $this->prefixView);				
			}
			require_once(VIEWS.$nome.'.phtml');
		}

		//-----------------------------------------------------------------------------------
		protected function Redirect($local, $vars = NULL) {
			if (is_array($vars) && count($vars) > 0) {
				extract($vars, EXTR_PREFIX_ALL, $this->prefixView);				
			}
			header('Location:'.$local);
			exit;
		}

		//-----------------------------------------------------------------------------------
		protected function regPOST($nome) {
			if (isset($_POST[$this->nomeRegForm]) && isset($_POST[$this->nomeRegForm][$nome])) {
				return $_POST[$this->nomeRegForm][$nome];
			}
			return NULL;
		}

		//-----------------------------------------------------------------------------------
		protected function ExtrairPOST($arrayCampos) {
			$dados = array();
			foreach ($arrayCampos as $nomeCampo) {
				$dados[$nomeCampo] = $this->regPOST($nomeCampo);
			}
			return $dados;
		}		

		//-----------------------------------------------------------------------------------
		protected function getDadosCache() {
			return $this->ExtrairPOST($this->camposEdicao);
		}

		//-----------------------------------------------------------------------------------
		protected function getDadosGravacao() {
			return $this->ExtrairPOST($this->camposPost);
		}

		//-----------------------------------------------------------------------------------
		protected function getDadosEdicao($id = 0) {
			$dadosView = $this->session->getDadosCache();

			if (isset($dadosView)) {		
				$lista = $dadosView;
			} else {
				$lista = array_fill_keys($this->camposEdicao, '');
				if ($id > 0) {					
					$dados = $this->model->Lista($id);
					$lista = array_merge($lista, $dados[0]);
				}
			}
			$datas['get'] = $lista;
			$datas[ACAO] = ($id > 0) ? ACAO_EDITAR : ACAO_INCLUIR;
	
			return $datas;
		}

		//-----------------------------------------------------------------------------------
		protected function getID() {
			$idParam = $this->getParam("id");
			$id = (int)$idParam;

			if (!$this->model->Existe("ID = $id")) {
				$this->session->addAlerta(NAO_ENCONTRADO);
				$this->Redirect($this->indexLocation);
			}
			return $id;
		}

		//-----------------------------------------------------------------------------------
		protected function redirectInterno($id = NULL) {
			if ($id > 0) {
				$this->Redirect($this->editLocation.$id, $this->getDadosEdicao($id));	
			} else {
				$this->Redirect($this->insertLocation, $this->getDadosEdicao());	
			}
		}

		//-----------------------------------------------------------------------------------		
		public function antesIncluir(&$dados) {
			return $dados;
		}

		public function Incluir() {
			$dados = $this->getDadosEdicao();
			$this->antesIncluir($dados);
			$this->view(CONTROLLER_EDICAO, $dados);	
		}

		//-----------------------------------------------------------------------------------		
		public function antesEditar(&$dados) {
			return $dados;
		}

		public function Editar($id = NULL) {
			$id = $this->getID();
			$dados = $this->getDadosEdicao($id);
			$this->antesEditar($dados);
			$this->view(CONTROLLER_EDICAO, $dados);
		}

		//-----------------------------------------------------------------------------------
		public function Excluir() {
			$id = $this->getID();
			$ok = $this->model->Delete("ID = $id");
			$this->depoisExclui($ok);
		}				

		protected function depoisExclui($ok) {			
			$this->session->addAlerta($ok ? EXCLUIDO : NAO_EXCLUIDO);	
			$this->Redirect($this->indexLocation);			
		}

		//-----------------------------------------------------------------------------------		
		public function antesGravar(&$dados) {
			return $dados;
		}

		//-----------------------------------------------------------------------------------		
		public function validar() {
			return TRUE;
		}

		//-----------------------------------------------------------------------------------
		public function gravar() {
			$id = (int)$this->regPOST("ID");

			$this->dataCache = $this->getDadosCache();
			$this->dataSet = $this->getDadosGravacao();
			
			if ($this->validar()) {
				$this->antesGravar($this->dataSet);	

				$ok = $this->model->Salvar($this->dataSet, $id); 			
				$this->session->addAlerta($ok ? SALVO : NAO_SALVO);	
				if ($ok)
					$this->Redirect($this->indexLocation);
			}			
			$this->session->setDadosCache($this->dataCache);
			$this->redirectInterno($id);			
		}
	}
?>