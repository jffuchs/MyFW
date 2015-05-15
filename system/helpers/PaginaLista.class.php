<?php	
	require_once "lib/raelgc/view/Template.php";	
    use raelgc\view\Template;

	class PaginaLista {

		private $ObjetoDados;
		private $arqTemplate;
		private $itensPorPagina = 13;
		private $paginaAtual;
		private $nomeController;

		public function __construct(Model $objDados) {
			$this->ObjetoDados = $objDados;
			$this->arqTemplate = "PaginaLista.html";
		}

		public function setArqTemplate($arquivo) {
			$this->arqTemplate = $arquivo;
		}

		public function setPaginaAtual($numero) {
			$this->paginaAtual = $numero;
		}

		public function setNomeController($nome) {
			$this->nomeController = $nome;
		}

		public function setItensPorPagina($numero) {
			$this->itensPorPagina = $numero;
		}

		public function show() {
			$oDados = $this->ObjetoDados;

			$msg = isset($_SESSION[MSG_ALERTAS]) ? $_SESSION[MSG_ALERTAS] : NULL;			

			$filtroSession = 'filtro'.$oDados::NOME_LISTA;
			$filtros = NULL;
			if (isset($_POST["filtros"])) {
				$filtros = $_POST["filtros"];
				$_SESSION[$filtroSession] = $filtros;
			} elseif (isset($_SESSION[$filtroSession])) {
				$filtros = $_SESSION[$filtroSession];
			}			
			$oDados->setValoresFiltros($filtros);

			$paginacao = new Paginacao($this->itensPorPagina);
			$paginacao->setPaginaAtual($this->paginaAtual);
			$paginacao->setTotalRegistros($oDados->getTotalRegistros());
			
			//$result = $oDados->setOrderBy("Nome")->getAll($paginacao->getInicio(), $paginacao->getLimite());
			$result = $oDados->getAll($paginacao->getInicio(), $paginacao->getLimite());

			$tpl = new Template($this->arqTemplate);

			$tpl->addFile("FILTRO_MODAL", "modalFiltro.php");	

			$tpl->addContexto("TABELA_CAMPOS", HtmlUtils::CamposTabela($oDados->getColunas()));
			$tpl->addContexto("FILTRO_CAMPOS", Htmlutils::CamposFiltros($oDados->getFiltros()));			

			$telaConf = ["Confirmação", "Este procedimento é irreversível.<br />Confirma proceder adiante e excluir o registro?", "danger", "Excluir"];
			if($tpl->exists("MODAL_EXCLUIR")) $tpl->MODAL_EXCLUIR = Htmlutils::MontarConfirmacao($telaConf);

			if($tpl->exists("TABELA_TITULOS")) $tpl->TABELA_TITULOS = HtmlUtils::TitulosTabela($oDados->getColunas(), $oDados->getOrderBy());
		    if($tpl->exists("NOME_CLASSE")) $tpl->NOME_CLASSE = $oDados::NOME_LISTA;
		    if($tpl->exists("NOME_LISTA")) $tpl->NOME_LISTA =  $oDados::NOME_LISTA;
		    if($tpl->exists("LINK_INCLUIR")) $tpl->LINK_INCLUIR = $this->nomeController.'/incluir';		    
		    if($tpl->exists("FILTRO_CAMPOS")) $tpl->FILTRO_CAMPOS = Htmlutils::CamposFiltros($oDados->getFiltros());
		    if($tpl->exists("ALERTA")) $tpl->ALERTA = Alert::render();
		    if($tpl->exists("COL_ACTIONS")) $tpl->COL_ACTIONS = sizeof($oDados->getColunas())-1;
    
		    foreach ($result as $dados) {
		    	foreach ($oDados->getColunas() as $fieldName => $valor) {
		    		if ($fieldName != "actions") {
		    			if($tpl->exists($fieldName))
		    			  $tpl->{"$fieldName"} = $dados[$fieldName];
		    		} else {
		    			$tpl->LINK_EDITAR = $this->nomeController.'/editar/id/'.$dados["ID"];
		    			$tpl->LINK_EXCLUIR = $this->nomeController.'/excluir/id/'.$dados["ID"];
		    			if($tpl->exists("REG_ID")) $tpl->REG_ID = $dados["ID"];
		    		}
		    	}
		    	$tpl->block("BLOCK_REGISTROS");
		    }

		    if($tpl->exists("TXT_REGISTROS")) {
		    	if (is_array($filtros)) {
		    		if (array_filter($filtros)) {
		    			$Aux = "<p>Encontrados <strong>{$oDados->getNrRegistros()}</strong> registro(s).</p>";	
		    		} else {
		    			$Aux = "<p>Exibindo <strong>{$oDados->getNrRegistros()}</strong> de um total de <strong>{$paginacao->getTotalRegistros()}</strong> Registros.</p>";	
		    		}		    	
		    		$tpl->TXT_REGISTROS = $Aux;
		    	}		    	
		    }
		    if($tpl->exists("NR_REGISTROS")) $tpl->NR_REGISTROS = $oDados->getNrRegistros();
		    if($tpl->exists("TOTAL_REGISTROS")) $tpl->TOTAL_REGISTROS = $paginacao->getTotalRegistros();
		    
		    if($tpl->exists("PAGINACAO")) $tpl->PAGINACAO = $paginacao->htmlPaginacao($this->nomeController);		    

		    $tpl->show();
		}
	}
?>