<?php	
	require_once "lib/raelgc/view/Template.php";	
    use raelgc\view\Template;

	class PaginaLista 
	{
		private $controller;
		private $objetoDados;
		private $arqTemplate;		
		//private $paginaAtual;
		private $path;		
		//private $itensPorPagina = 20;

		public function __construct(Model $objDados, Controller $objCtrl) 
		{
			$this->controller = $objCtrl;
			$this->objetoDados = $objDados;
			$this->arqTemplate = "PaginaLista.phtml";
		}

		public function setArqTemplate($arquivo) 
		{
			$this->arqTemplate = $arquivo;
		}

		/*public function setPaginaAtual($numero) 
		{
			$this->paginaAtual = $numero;
		}*/

		public function setPath($path) 
		{
			$this->path = $path;
		}

		/*public function setItensPorPagina($numero) 
		{
			$this->itensPorPagina = $numero;
		}*/

		public function show() 
		{
			$oDados = $this->objetoDados;
			$oCtrl = $this->controller;

//var_dump(Session::get('fornecedores_filter_text')); 
//exit;

			$this->controller->filtros->getValuesFromSession($oDados::NOME_LISTA);
			$filtros = $this->controller->filtros->getText();
			$camposFiltros = $oCtrl->filtros->getParams();
			//$totalRegistros = $oDados->getRecordCount($filtros);

			/*$paginacao = new Paginacao($this->itensPorPagina);
			$paginacao->setTotalRegistros($totalRegistros);
			if ($paginacao->getTotalPaginas() < $this->paginaAtual) {
				$this->setPaginaAtual($paginacao->getTotalPaginas());
			}
			$paginacao->setPaginaAtual($this->paginaAtual);						
			$result = $oDados->getAll($paginacao->getInicio(), $paginacao->getLimite(), $filtros, $oCtrl->getOrderBy());*/

			$result = $oDados->getAll(1, 100000000, $filtros, $oCtrl->getOrderBy());

			$tpl = new Template($this->arqTemplate);

			$tpl->addFile("FILTRO_MODAL", "modalFiltro.php");	

			$tpl->addContexto("TABELA_CAMPOS", HtmlUtils::CamposTabela($oCtrl->colunas->get()));
			$tpl->addContexto("FILTRO_CAMPOS", Htmlutils::CamposFiltros($camposFiltros));			

			$telaConf = ["Confirmação", "Este procedimento é irreversível.<br />Confirma proceder adiante e excluir o registro?", "danger", "Excluir"];
			if($tpl->exists("MODAL_EXCLUIR")) $tpl->MODAL_EXCLUIR = Htmlutils::MontarConfirmacao($telaConf);

			if($tpl->exists("TABELA_TITULOS")) $tpl->TABELA_TITULOS = HtmlUtils::TitulosTabela($oCtrl->colunas->get(), $oCtrl->getOrderBy());
		    if($tpl->exists("NOME_LISTA")) $tpl->NOME_LISTA =  $oDados::NOME_LISTA;
		    if($tpl->exists("LINK_INCLUIR")) $tpl->LINK_INCLUIR = $this->path.'/incluir';		    
		    if($tpl->exists("FILTRO_CAMPOS")) $tpl->FILTRO_CAMPOS = Htmlutils::CamposFiltros($camposFiltros);
		    if($tpl->exists("ALERTA")) $tpl->ALERTA = Alert::render();
		    if($tpl->exists("COL_ACTIONS")) $tpl->COL_ACTIONS = sizeof($oCtrl->colunas->get())-1;

		    //Ver isso depois, se não é melhor!
		    $tpl->set("NOME_LISTA", $oDados::NOME_LISTA);
		    $tpl->set("PATH", PATH);
		    $tpl->set("BREADCRUMBS", HtmlUtils::MontarBreadCrumbs($oDados::NOME_LISTA));
    
		    foreach ($result as $dados) 
		    {
		    	foreach ($oCtrl->colunas->get() as $fieldName => $valor) 
		    	{
		    		if ($fieldName != "actions") {
		    			if($tpl->exists($fieldName))
		    			  $tpl->{"$fieldName"} = $dados[$fieldName];
		    		} else {
		    			$tpl->LINK_EDITAR = $this->path.'/editar/id/'.$dados["ID"];
		    			$tpl->LINK_EXCLUIR = $this->path.'/excluir/id/'.$dados["ID"];
		    			if($tpl->exists("REG_ID")) $tpl->REG_ID = $dados["ID"];
		    		}
		    	}
		    	$tpl->block("BLOCK_REGISTROS");
		    }

		    if($tpl->exists("TXT_REGISTROS")) {
		    	if ($filtros) {
		    		$Aux = '<p align="center">Encontrados <strong>'.$oDados->getRecordCountFromLastRead().'</strong> registro(s).</p>';	
		    	} else {
		    		$Aux = '<p align="center">Exibindo <strong>'.$oDados->getRecordCountFromLastRead().'</strong> de um total de <strong>'.$totalRegistros.'</strong> Registros.</p>';	
		    	}		    			    		
		    	$tpl->TXT_REGISTROS = $Aux;	    	
		    }

		    //if($tpl->exists("NR_REGISTROS")) $tpl->NR_REGISTROS = $oDados->getRecordCountFromLastRead();
		    //if($tpl->exists("TOTAL_REGISTROS")) $tpl->TOTAL_REGISTROS = $totalRegistros;		    
		    //if($tpl->exists("PAGINACAO")) $tpl->PAGINACAO = $paginacao->htmlPaginacao($this->path);		    

		    $tpl->show();
		}
	}
?>