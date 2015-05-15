 <?php
	class Session 
	{		
		public static function init() {        	
        	if (session_id() == '') {
            	session_start();
        	}
    	}

		public static function set($key, $value) {
        	$_SESSION[$key] = $value;
    	}

    	public static function get($key) {
        	if (isset($_SESSION[$key])) {
            	return $_SESSION[$key];
        	}
    	}

    	public static function add($key, $value) {
        	$_SESSION[$key][] = $value;
    	}

    	public static function destroy() {
        	session_destroy();
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