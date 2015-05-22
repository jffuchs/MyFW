<?php
	class Controller extends Router
	{
		protected $nome;
		protected $repository;
		protected $locationIndex;
		protected $locationIndexPaginate;
		protected $locationEdit;
		protected $locationInsert;
		protected $camposEdicao;
		protected $camposPost;
		protected $pagina;
		protected $prefixView;
		protected $regForm;
		protected $dataCache;		//dados que vem do POST
		protected $dataSet;			//dados que irão para o BD

		//-----------------------------------------------------------------------------------
		public function __construct($nome = NULL) 
		{
			parent::__construct();

			if (isset($nome)) {
				$this->setNome($nome);
			}
			$this->prefixView = 'view';
			$this->regForm = 'RegForm';
		}		

		//-----------------------------------------------------------------------------------
		private function loadRepository() {
			$repo_path = REPOSITORIES.$this->nome.'Repo.php';
			
			if (!file_exists($repo_path)) {				
				Warning::page404("Arquivo de repositório <strong>{$repo_path}</strong> não encontrado!");
				exit;
			}
			$nomeClasseRepo = $this->nome.'Repo';
			$this->repository = new $nomeClasseRepo($this->nome);
		}

		//-----------------------------------------------------------------------------------
		protected function setNome($nome) 
		{
			$this->nome = $nome;

			$this->locationIndex = PATH.$nome;
			$this->locationIndexPaginate = PATH.$nome.'/index/pag/';
			$this->locationEdit = PATH.$nome.'/editar/id/';
			$this->locationInsert = PATH.$nome.'/incluir';

			define('CONTROLLER_EDICAO', $nome.'Incluir');

			$this->loadRepository();
		}

		//-----------------------------------------------------------------------------------
		public function index_action() 
		{
			Session::set(DADOS_CACHE, NULL);

			Session::set('actualPage', $this->pageNumber);

			$pagina = new PaginaLista($this->repository->model);
			$pagina->setPaginaAtual($this->pageNumber);
			$pagina->setPath(PATH.$this->nome);
			$pagina->show();
		}

		//-----------------------------------------------------------------------------------
		protected function view($nome, $vars = NULL) 
		{
			if (is_array($vars) && count($vars) > 0) {
				extract($vars, EXTR_PREFIX_ALL, $this->prefixView);				
			}
			require_once(VIEWS.$nome.'.phtml');
		}

		//-----------------------------------------------------------------------------------
		protected function regPOST($nome) 
		{
			return Request::post($this->regForm)[$nome];			
		}

		//-----------------------------------------------------------------------------------
		protected function extrairPOST($arrayCampos) 
		{
			$dados = array();
			foreach ($arrayCampos as $nomeCampo) {
				$dados[$nomeCampo] = $this->regPOST($nomeCampo);
			}
			return $dados;
		}		

		//-----------------------------------------------------------------------------------
		protected function getDataView() 
		{
			return $this->extrairPOST($this->camposEdicao);
		}

		//-----------------------------------------------------------------------------------
		protected function getDadosGravacao() 
		{
			return $this->extrairPOST($this->camposPost);
		}

		//-----------------------------------------------------------------------------------
		protected function getDadosEdicao($id = 0) 
		{
			$dataView = Session::get(DADOS_CACHE);

			if (isset($dataView)) {		
				$lista = $dataView;
			} else {
				$lista = array_fill_keys($this->camposEdicao, '');
				if ($id > 0) {					
					$dados = $this->repository->lista($id);
					$lista = array_merge($lista, $dados[0]);
				}
			}
			$datas['get'] = $lista;
			$datas[ACAO] = ($id > 0) ? ACAO_EDITAR : ACAO_INCLUIR;
			$datas['linkCancelar'] = $this->redirectIndexPaginate(TRUE);
	
			return $datas;
		}

		//-----------------------------------------------------------------------------------
		protected function getID() 
		{
			$idParam = $this->getParam("id");
			$id = (int)$idParam;

			if (!$this->repository->find("ID = $id")) {
				Alert::set(NAO_ENCONTRADO);
				Redirect::to($this->locationIndex);
			}
			return $id;
		}

		//-----------------------------------------------------------------------------------
		protected function redirectEditOrInsert($id = NULL) 
		{
			if ($id > 0) {
				Redirect::to($this->locationEdit.$id);	
			} else {
				Redirect::to($this->locationInsert);	
			}
		}

		//-----------------------------------------------------------------------------------
		protected function redirectIndexPaginate($retornarLink = NULL) 
		{
			$link = $this->locationIndexPaginate.Session::get('actualPage');
			if (isset($retornarLink)) {
				return $link;
			}
			Redirect::to($link);
		}

		//-----------------------------------------------------------------------------------		
		public function antesIncluir(&$dados) 
		{
			return $dados;
		}

		public function incluir() 
		{
			$dados = $this->getDadosEdicao();
			$this->antesIncluir($dados);
			$this->view(CONTROLLER_EDICAO, $dados);	
		}

		//-----------------------------------------------------------------------------------		
		public function antesEditar(&$dados) 
		{
			return $dados;
		}

		public function editar($id = NULL) 
		{
			$id = $this->getID();
			$dados = $this->getDadosEdicao($id);
			$this->antesEditar($dados);
			$this->view(CONTROLLER_EDICAO, $dados);
		}

		//-----------------------------------------------------------------------------------
		public function excluir() 
		{
			$id = $this->getID();
			$ok = $this->repository->Delete($id);
			$this->depoisExcluir($ok);
		}				

		protected function depoisExcluir($ok) 
		{			
			Alert::set($ok ? EXCLUIDO : NAO_EXCLUIDO);	
			$this->redirectIndexPaginate();
		}

		//-----------------------------------------------------------------------------------		
		public function antesGravar(&$dados) 
		{
			return $dados;
		}

		//-----------------------------------------------------------------------------------		
		public function validar() 
		{
			return TRUE;
		}

		//-----------------------------------------------------------------------------------
		public function gravar() 
		{
			$id = (int)$this->regPOST("ID");

			$this->dataCache = $this->getDataView();
			$this->dataSet = $this->getDadosGravacao();
			
			if ($this->validar()) {
				$this->antesGravar($this->dataSet);	

				$ok = $this->repository->salvar($this->dataSet, $id); 
				//$ok = FALSE;

				Alert::set($ok ? SALVO : NAO_SALVO);

				if ($ok) {
					$this->redirectIndexPaginate();
				}					
			}						
			Session::set(DADOS_CACHE, $this->dataCache);
			$this->redirectEditOrInsert($id);			
		}
	}
?>