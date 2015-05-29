<?php 
    class FieldDef 
    {
        private $fields;

        public function add($key, $label, $type, $value, $required) 
        {
            $this->fields[$key] = array($label, $type, $value, $required);
        }

        public function setValue($key, $value)
        {
            if (array_key_exists($key, $fields)) {
                $this->fields[$key][2] = $value; 
            }
            return $this;
        }
    }
?>