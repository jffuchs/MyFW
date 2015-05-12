 <?php
	class Session 
	{		
		//-----------------------------------------------------------------------------------
		public function addAlerta($tipo, $msg = NULL) {			
			$_SESSION[MSG_ALERTAS] = HtmlUtils::MontarAlerta($tipo, $msg);	
			return $this;
		}

		public function getAlerta() {
			return isset($_SESSION[MSG_ALERTAS]) ? $_SESSION[MSG_ALERTAS] : NULL;
		}

		public function limparAlertas() {			
			$_SESSION[MSG_ALERTAS] = NULL;
		}

		//-----------------------------------------------------------------------------------
		public function setDadosCache($dados) {			
			$_SESSION[DADOS_CACHE] = $dados;
		}

		public function getDadosCache() {
			return isset($_SESSION[DADOS_CACHE]) ? $_SESSION[DADOS_CACHE] : NULL;
		}
	}
?>