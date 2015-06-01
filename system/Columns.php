<?php
    class Columns 
    {
        private $fields;

        public function add($key, $caption, $type, $classWidth, $align = NULL) 
        {
            $this->fields[$key] = array($caption, $type, $classWidth, $align);
            return $this;
        }

        public function get() 
        {
            return $this->fields;
        }        
    }
?>