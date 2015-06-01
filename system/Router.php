<?php
	class Router 
	{
		private $url;
		private $parts;

		public $controller;
		public $action;
		public $params;	
		public $session;	
		public $pageNumber;

		//-----------------------------------------------------------------------------------
		public function __construct() 
		{
			$this->setUrl();
			$this->parseUrl();		
			$this->setController();		
			$this->setAction();					
			$this->setParams();
			$this->setPageNumber();

			$this->session = new Session;
		}

		//Extrair a URL 
		private function setUrl() 
		{
			$_GET['url'] = (isset($_GET['url']) ? $_GET['url'] : 'index/index_action');
			$this->url = $_GET['url'];
		}

		//Separar as diversas partes da URL
		private function parseUrl() 
		{
			$this->parts = explode('/', $this->url);				
		}

		//Controller é a primeira parte da URL
		private function setController() 
		{
			$this->controller = $this->parts[0];			
		}

		//Extrair a action da URL ou seta como default 'index_action'
		private function setAction() 
		{
			$ac = (!isset($this->parts[1]) || 
				          $this->parts[1] == NULL || 
				          $this->parts[1] == 'index') ? 'index_action' : $this->parts[1];
			$this->action = $ac;
		}

		//Cria um array com os parâmetros/valor da action...
		private function setParams() 
		{
			unset($this->parts[0], $this->parts[1]);	

			if (end($this->parts) == NULL) {
				array_pop($this->parts);
			}

			$ind = array();
			$value = array();

			$i = 0;
			if (!empty($this->parts)) {
				foreach ($this->parts as $val) 
				{
					if ($i % 2 == 0)
						$ind[] = $val;						
					else
						$value[] = $val;
					$i++;
				}
			}

			if (count($ind) == count($value) && !empty($ind) && !empty($value)) {
				$this->params = array_combine($ind, $value);
			} else {
				$this->params = array();
			}
		}

		//Retorna o valor de um parâmetro ou todo o array caso não exista
		public function getParam($name = NULL) 
		{
			return isset($this->params[$name]) ? $this->params[$name] : NULL;					  
		}

		//-----------------------------------------------------------------------------------
		protected function setPageNumber()
		{
			$this->pageNumber = $this->getParam("pag");
			if ($this->pageNumber < 1 or empty($this->pageNumber)) {
				$this->pageNumber = 1;	
			}			
		}

		//Executa o action da controller
		public function run() 
		{
			$controller_path = CONTROLLERS.$this->controller.'Controller.php';
			
			if (!file_exists($controller_path)) {				
				Warning::page404("Arquivo de controller <b>{$controller_path}</b> não encontrado!");
				exit;
			}

			require_once($controller_path);

			$app = new $this->controller();			

			if (!method_exists($app, $this->action)) {
				Warning::page404("Action <b>{$this->action}</b> do arquivo de controller <b>{$controller_path}</b> não encontrado!");
				exit;
			}

			$action = $this->action;			
			$app->$action();

			Alert::clear();
		}
	}
?>