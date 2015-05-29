<?php 
	class Filter 
	{
		private $params;
        private $values;

        const COL_OPERATOR = 1;
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
        	$filtroSession = 'filtro'.$nomeLista;
			$filtros = Request::post("filtros");
			if (isset($filtros)) {
				Session::set($filtroSession, $filtros);
			} else {
				$filtros = Session::get($filtroSession);
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

            /*if (!$this->values) {
                return NULL;
            } else {
                $result = "";
                $aux = $this->params;
                for ($i=0; $i < count($aux); $i++) 
                { 
                    if ($this->values[$i]) {
                        if ($result) {
                            $result .= " AND ";
                        }
                        if ($aux[$i][2] == "LIKE") {
                            $result .= $aux[$i][0]." LIKE '%".$this->values[$i]."%'";
                        } else {
                            $result .= $aux[$i][0].' '.sprintf($aux[$i][2], $this->values[$i]); 
                        }                       
                    }                   
                }               
            }
            if ($result) {
                $result = ' WHERE '.$result;
            }
            return $result;*/
        }
	}
?>