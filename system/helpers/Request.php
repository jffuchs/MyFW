<?php
    class Request
    {
        public static function post($key, $clean = FALSE)
        {
            if (isset($_POST[$key])) {
                return ($clean) ? trim(strip_tags($_POST[$key])) : $_POST[$key];
            }
            return NULL;
        }

        public static function get($key)
        {
            if (isset($_GET[$key])) {
                return $_GET[$key];
            }
            return NULL;
        }

        public static function cookie($key)
        {
            if (isset($_COOKIE[$key])) {
                return $_COOKIE[$key];
            }
            return NULL;
        }
    }
?>
