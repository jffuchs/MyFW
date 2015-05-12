<?php
	class System 
	{
		private $url;
		private $partes;

		public $controller;
		public $action;
		public $params;	
		public $session;	

		public function __construct() {
			$this->setUrl();
			$this->setPartes();		
			$this->setController();		
			$this->setAction();					
			$this->setParams();

			$this->session = new Session;
		}

		//Extrair a URL 
		private function setUrl() {
			$_GET['url'] = (isset($_GET['url']) ? $_GET['url'] : 'index/index_action');
			$this->url = $_GET['url'];
		}

		//Separar as diversas partes da URL
		private function setPartes() {
			$this->partes = explode('/', $this->url);				
		}

		//Controller é a primeira parte da URL
		private function setController() {
			$this->controller = $this->partes[0];			
		}

		//Extrair a action da URL ou seta como default 'index_action'
		private function setAction() {
			$ac = (!isset($this->partes[1]) || 
				          $this->partes[1] == NULL || 
				          $this->partes[1] == 'index') ? 'index_action' : $this->partes[1];
			$this->action = $ac;
		}

		//Cria um array com os parâmetros/valor da action...
		private function setParams() {
			unset($this->partes[0], $this->partes[1]);	

			if (end($this->partes) == NULL) {
				array_pop($this->partes);
			}

			$ind = array();
			$value = array();

			$i = 0;
			if (!empty($this->partes)) {
				foreach ($this->partes as $val) {
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
		public function getParam($name = NULL) {
			return isset($this->params[$name]) ? $this->params[$name] : NULL;					  
		}

		/*public function getFromPOST($nome) {
			return isset($_POST[$nome]) ? $_POST[$nome] : NULL;
		}*/

		//Executa o action da controller
		public function run() {
			$controller_path = CONTROLLERS.$this->controller.'Controller.php';
			
			if (!file_exists($controller_path)) {
				require_once(VIEWS.'404.phtml');
				exit;
			}

			require_once($controller_path);

			$app = new $this->controller();			

			if (!method_exists($app, $this->action)) {
				require_once(VIEWS.'404.phtml');
				exit;
			}

			$action = $this->action;			
			$app->$action();

			$this->session->limparAlertas();
		}
	}
?>