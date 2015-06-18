<?php
	require_once "lib/raelgc/view/Template.php";
    use raelgc\view\Template;

	class IndexPage
	{
		private $arqTemplate;
		private $controller;

		public function __construct(Controller $objCtrl)
		{
			$this->controller = $objCtrl;
			$this->arqTemplate = "Template.phtml";
		}

		public function setArqTemplate($arquivo)
		{
			$this->arqTemplate = $arquivo;
		}

		public function show($ehIndex, $arqView = NULL, $vars = NULL)
		{
			$oCtrl = $this->controller;

			$tpl = new Template($this->arqTemplate);

			if (isset($arqView)) {
				$tpl->addFile("PAGE_CONTENT", $arqView, $vars);
			}

			//Macros do HTML/Template principal...
			$tpl->set("PATH", PATH);
			$tpl->set("PATH_PUBLIC", PATH_PUBLIC);
			$tpl->set("USU_ID", Session::getFrom('Login','ID'));
			$tpl->set("USU_APELIDO", Session::getFrom('Login','Apelido'));
			$tpl->set("MENUS", Session::get('menu'));

			//Se é um controller/index
			if ($ehIndex) {
				$pagina = new PaginaLista($oCtrl->repository->model, $oCtrl);
				//$pagina->setPaginaAtual($oCtrl->pageNumber);
				$pagina->setPaginaAtual(Session::getFrom($oCtrl->nomeLogico, 'actualPage'));
				$pagina->setPath(PATH.$oCtrl->nome);
				$pagina->show($tpl, False);
			}
			$tpl->show();
		}
	}
?>
