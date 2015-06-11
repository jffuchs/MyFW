 <?php
	class Session 
	{		
		public static function init() 
        {        	
        	if (session_id() == '') {
            	session_start();
                return TRUE;
        	}
            return FALSE;
    	}

        public static function started()
        {
            return (session_id() == '') ? FALSE : TRUE;
        }

		public static function set($key, $value) 
        {
        	$_SESSION[$key] = $value;
    	}

    	public static function get($key) 
        {
        	if (isset($_SESSION[$key])) {
            	return $_SESSION[$key];
        	}
    	}

        public static function delete($key)
        {
            unset($_SESSION[$key]);
        }

    	public static function setPlus($keyPrimary, $key, $value) 
        {
        	$_SESSION[$keyPrimary][$key] = $value;
    	}

        public static function getFrom($keyPrimary, $key)
        {
            if (isset($_SESSION[$keyPrimary])) {
                if (isset($_SESSION[$keyPrimary][$key])) {
                    return $_SESSION[$keyPrimary][$key];
                }
            }            
        }

    	public static function destroy() 
        {
        	session_destroy();
    	}		
	}
?>