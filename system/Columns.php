<?php
    class Columns 
    {
        private $fields;

        public function add($key, $caption, $type, $classWidth) 
        {
            $this->fields[$key] = array($caption, $type, $classWidth);
            return $this;
        }

        public function getColunas() 
        {
            return $this->fields;
        }        
    }
?>