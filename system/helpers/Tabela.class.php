<?php 
	/**
	* Classe para manipulação de BD utilizando PDO	
	*/
	class Tabela {		

		const NOME = "";
		const NOME_LISTA = "";
		const PAGE_BD = "";
		const PAGE_LIST = "";
		const PAGE_EDIT = "";

		protected $orderBy;
		protected $nrRegistros;
		protected $valoresFiltros;
		protected $colunas;

		public function getColunas() {
			return $this->colunas;
		}

		public function setValoresFiltros($value) {
			$this->valoresFiltros = $value;
		}

		public function getOrderBy() {
			return $this->orderBy;
		}	
		public function setOrderBy($value) {
			$this->orderBy = $value;
			return $this;
		}

		public function getNrRegistros() {
			return $this->nrRegistros;
		}		

		private function getFiltroTxt() 
		{
			if (!$this->valoresFiltros) 
			{
				return NULL;
			} else 
			{
				$result = "";
				$aux = $this->getFiltros();
				for ($i=0; $i < count($aux); $i++) 
				{ 
					if ($this->valoresFiltros[$i]) 
					{
						if ($result) 
						{
							$result .= " AND ";
						}
						if ($aux[$i][2] == "LIKE") {
							$result .= $aux[$i][0]." LIKE '%".$this->valoresFiltros[$i]."%'";
						} else {
							$result .= $aux[$i][0].' '.sprintf($aux[$i][2], $this->valoresFiltros[$i]);	
						}						
					}					
				}				
			}
			if ($result) {
				$result = ' WHERE '.$result;
			}
			return $result;
		}

		public function getTotalRegistros() 
		{
			$query = "SELECT 1 FROM ".$this->nomeTabela;
			if ($this->valoresFiltros) 
			{
				$query .= $this->getFiltroTxt();
			}
			$sth = $this->conexao->query($query);
    		return $sth->rowCount();
		}

		public function getAll($inicio, $limite)
		{
			$query = "SELECT * FROM ".$this->nomeTabela;

			$query .= $this->getFiltroTxt();
			
			if ($this->orderBy) {
				$query .= " ORDER BY ".$this->orderBy;
			}
			if ($limite) {
				$query .= " LIMIT $inicio, $limite";
			}			
			$stm = $this->conexao->prepare($query);			
			$stm->execute();
			$this->nrRegistros = $stm->rowCount();

			return $stm->fetchAll(PDO::FETCH_ASSOC);	//FETCH_OBJ
		}		

		public function getHtmlTitulos() {			
			$Aux = '';
			foreach ($this->getColunas() as $fieldName => $fieldTitle) {
				if ($fieldName != "actions") {
				  	$class = sprintf('<th class="header%s">', ($fieldName == $this->getOrderBy()) ? " headerSortDown" : "");
				} else {
					$class = '<th class="col-xs-2">';
				}				
				$Aux .= $class.$fieldTitle."</th>";
			}			
			return "<tr>$Aux</tr>";
		}

		public function getHtmlCampos() {			
			$Aux = '';
			foreach ($this->getColunas() as $fieldName => $valor) {
				if ($fieldName != "actions") {
					$Aux .= "<td>{".$fieldName."}</td>";
				}
			}			
			return $Aux;
		}

		public function getHtmlFiltros() {
			$Aux = '';
			$arrayFiltros = $this->getFiltros();
        	for ($i=0; $i < count($arrayFiltros); $i++) { 
        		$Aux .= '<div class="form-group">
                         <label>'.$arrayFiltros[$i][1].'</label>  
                         <input type="'.$arrayFiltros[$i][3].'" name="filtros[]" class="form-control">
                         </div>';
        	}
        	return $Aux;
		}
	}
?>