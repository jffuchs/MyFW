<?php 
	class Filter 
	{
		private $params;
        private $values;

        const COL_OPERATOR = 1;
        const COL_TYPE = 2;
        const COL_VALUE = 3;

        //-----------------------------------------------------------------------------------
		public function add($key, $label, $operator, $type, $value = NULL) 
		{
			$this->params[$key] = array($label, $operator, $type, $value);
            return $this;
		}

        public function getParams() 
        {
            return $this->params;
        }

        //-----------------------------------------------------------------------------------
        public function setValues($values)
        {
            $this->values = $values;

            $i = 0;
            foreach($this->params as $key => $value)
            {
                $this->params[$key][self::COL_VALUE] = $values[$i];
                $i += 1;
            }
            return $this;
        }

        public function getValues() 
        {
        	return $this->values;
        }

        public function getValuesFromSession($nomeLista) 
        {
        	$filtros = Request::post("filtros");
			if (isset($filtros)) {
				Session::setAdd($nomeLista, 'Filtros', $filtros);
			} else {
				$filtros = Session::getFrom($nomeLista, 'Filtros');
			}
			$this->setValues($filtros);
        }

        //-----------------------------------------------------------------------------------
        public function getText() 
        {
            $result = "";
            foreach($this->params as $key => $value)
            {
                $valor = $this->params[$key][self::COL_VALUE];
                if ($valor) {
                    if ($result) {
                        $result .= " AND ";
                    }                
                    if ($this->params[$key][self::COL_OPERATOR] == "LIKE") {
                        $result .= $key." LIKE '%".$valor."%'";
                    } else {
                        $result .= $key.' = '.$valor; 
                    }
                }                
            }
            return $result;            
        }

        //-----------------------------------------------------------------------------------
        public function getTextAnyField($text) 
        {
            $result = "";
            foreach($this->params as $key => $value)
            {                
                if ($this->params[$key][self::COL_OPERATOR] == "LIKE") {
                    $parametros = array($key, $text, $key." LIKE '%".$text."%'");
                } elseif ($this->params[$key][self::COL_TYPE] == "number") {                    
                    $valor = abs(filter_var($text, FILTER_SANITIZE_NUMBER_INT));
                    $parametros = array($key, $valor, $key.' = '.$valor);
                }
                if ($parametros[1]) {
                    if ($result) {
                       $result .= " OR ";
                    }
                    $result .= $parametros[2]; 
                }
            }
            return $result;            
        }
	}
?>