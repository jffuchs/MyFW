<?php
	class Controller extends Router
	{
		protected $locationIndex;
		protected $locationIndexPaginate;
		protected $locationEdit;
		protected $locationInsert;
		protected $camposEdicao;
		protected $camposPost;
		protected $prefixView;
		protected $regForm;
		protected $dataCache;		//dados que vem do POST
		protected $dataSet;			//dados que irão para o BD
		protected $orderBy;

		public $nomeLogico;
		public $repository;
		public $nome;
		public $nomeCampoID;
		public $colunas;
		public $filtros;
		public $SQL;

		//-----------------------------------------------------------------------------------
		public function __construct($nome = NULL, $nomeLogico = NULL)
		{
			parent::__construct();

			$this->nomeLogico = $nomeLogico;

			if (isset($nome)) {
				$this->setNome($nome);
			}
			$this->prefixView = 'view';
			$this->regForm = 'RegForm';
			$this->nomeCampoID = 'ID';

			$this->SQL = '';
			$this->colunas = new Columns();
			$this->filtros = new Filter();
		}

		//-----------------------------------------------------------------------------------
		private function loadRepository()
		{
			$repo_path = REPOSITORIES.$this->nome.'Repo.php';

			if (!file_exists($repo_path)) {
				Warning::page404("Arquivo de repositório <b>{$repo_path}</b> não encontrado!");
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
			Session::setPlus($this->nomeLogico, DADOS_CACHE, NULL);
			//Session::setPlus($this->nomeLogico, 'actualPage', $this->pageNumber);

			$pagina = new IndexPage($this);
			$pagina->show(TRUE, "PaginaLista.html");

			/*$pagina = new PaginaLista($this->repository->model, $this);
			$pagina->setPaginaAtual($this->pageNumber);
			$pagina->setPath(PATH.$this->nome);
			$pagina->show();*/
		}

		//-----------------------------------------------------------------------------------
		protected function view($nome, $vars = NULL)
		{
			$arqView = VIEWS.$nome.'.php';
			if (!file_exists($arqView)) {
				$arqView = VIEWS.$nome.'.phtml';
				if (!file_exists($arqView)) {
					Warning::page404("Arquivo de view <b>{$arqView}</b> não encontrado!");
					exit;
				}
			}

			$pagina = new IndexPage($this);
			$pagina->show(FALSE, $arqView, $vars);
			//require_once($arqView);
		}

		//-----------------------------------------------------------------------------------
		protected function regPOST($nome)
		{
			if (isset(Request::post($this->regForm)[$nome])) {
				return Request::post($this->regForm)[$nome];
			}
			return NULL;
		}

		//-----------------------------------------------------------------------------------
		protected function extrairPOST($arrayCampos)
		{
			$dados = array();
			foreach ($arrayCampos as $nomeCampo)
			{
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

		protected function getRecord($id)
		{
			$lista = array_fill_keys($this->camposEdicao, '');
			if ($id > 0) {
				$dados = $this->repository->lista($id);
				$lista = array_merge($lista, $dados[0]);
			}
			return $lista;
		}

		//-----------------------------------------------------------------------------------
		protected function getDadosEdicao($id = 0)
		{
			$dataView = Session::getFrom($this->nomeLogico, DADOS_CACHE);

			if (isset($dataView)) {
				$lista = $dataView;
			} else {
				/*$lista = array_fill_keys($this->camposEdicao, '');
				if ($id > 0) {
					$dados = $this->repository->lista($id);
					$lista = array_merge($lista, $dados[0]);
				}*/
				$lista = $this->getRecord($id);
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
			//$link = $this->locationIndexPaginate.Session::getFrom($this->nomeLogico, 'actualPage');
			$link = $this->locationIndex;
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
			Session::setPlus($this->nomeLogico, DADOS_CACHE, $this->dataCache);
			$this->redirectEditOrInsert($id);
		}
	}
?>
