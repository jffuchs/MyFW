<?php 
	class Filter 
	{
		private $params;
        private $formValues;

		public function add($key, $label, $operator, $value = NULL) 
		{
			$this->params[$key] = array($label, $operator, $value);
            return $this;
		}

        public function getParams() 
        {
            return $this->params;
        }

        public function remove($key)
        {
            if (array_key_exists($key, $params)) {
                unset($this->params[$key]);
            }
            return $this;
        }

        public function setFormValues($values)
        {
            $this->formValues = $values;
            return $this;
        }

        public function getText() 
        {
            if (!$this->formValues) {
                return NULL;
            } else {
                $result = "";
                $aux = $this->params;
                for ($i=0; $i < count($aux); $i++) { 
                    if ($this->formValues[$i]) {
                        if ($result) {
                            $result .= " AND ";
                        }
                        if ($aux[$i][2] == "LIKE") {
                            $result .= $aux[$i][0]." LIKE '%".$this->formValues[$i]."%'";
                        } else {
                            $result .= $aux[$i][0].' '.sprintf($aux[$i][2], $this->formValues[$i]); 
                        }                       
                    }                   
                }               
            }
            if ($result) {
                $result = ' WHERE '.$result;
            }
            return $result;
        }
	}
?>