<?php 
	class Model 
	{
		protected $db;
		protected $nomeTabela;
		protected $orderBy;
		protected $nrRegistros;
		protected $valoresFiltros;
		protected $colunas;
		protected $filtros;		

		const NOME = "";
		const NOME_LISTA = "";		

		public function __construct($aNomeTabela) 
		{
			$this->nomeTabela = $aNomeTabela;
			$this->db = new PDO('mysql:host=localhost;dbname=phpbasico', 'root', '');
		}

		public function setColunas($value) 
		{
			$this->colunas = $value;
			return $this;
		}

		public function getColunas() 
		{
			return $this->colunas;
		}
		
		public function setFiltros($value) 
		{
			$this->filtros = $value;
			return $this;
		}

		public function getFiltros() 
		{
			return $this->filtros;
		}			

		public function setOrderBy($value) 
		{
			$this->orderBy = $value;
			return $this;
		}

		public function getOrderBy() 
		{
			return $this->orderBy;
		}	

		public function setValoresFiltros($value) 
		{
			$this->valoresFiltros = $value;
			return $this;
		}

		public function getNrRegistros() 
		{
			return $this->nrRegistros;
		}

		public function getTotalRegistros() 
		{
			$query = "SELECT 1 FROM ".$this->nomeTabela;
			if ($this->valoresFiltros) {
				$query .= $this->getFilterText();
			}
			$sth = $this->db->query($query);
    		return $sth->rowCount();
		}

		private function getFilterText() 
		{
			if (!$this->valoresFiltros) {
				return NULL;
			} else {
				$result = "";
				$aux = $this->getFiltros();
				for ($i=0; $i < count($aux); $i++) { 
					if ($this->valoresFiltros[$i]) {
						if ($result) {
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

		//--------------------------------------------------------------------------------------------

		public function insert(Array $dados) 
		{
			$campos = implode(", ", array_keys($dados));
			$valores = "'".implode("', '", array_values($dados))."'";

			$sql = "INSERT INTO {$this->nomeTabela} ({$campos}) VALUES ({$valores})";
			return $this->db->query($sql);
		}		

		public function update(Array $dados, $where = NULL) 
		{
			$where = ($where != NULL ? "WHERE {$where};" : "");

			foreach ($dados as $inds => $vals) {
				$campos[] = "{$inds} = '{$vals}'";				
			}
			$campos = implode(", ", $campos);

			$sql = "UPDATE {$this->nomeTabela} SET {$campos} ".$where;
  			return $this->db->query($sql);
		}	

		public function delete($where = NULL) 
		{
			if ($where != NULL) {				
				$sql = "DELETE FROM {$this->nomeTabela} WHERE ".$where;
				return $this->db->query($sql);
			} else {
				return FALSE;
			}			
		}

		public function read($where = NULL, $limit = null, $orderBy = NULL) 
		{			
			$where = ($where != NULL ? " WHERE {$where}" : "");
			$limit = ($limit != NULL ? " LIMIT {$limit}" : "");
			$orderBy = ($orderBy != NULL ? " ORDER BY {$orderBy}" : "");
			$sql = "SELECT * FROM {$this->nomeTabela}".$where.$orderBy.$limit;
			$q = $this->db->query($sql);
			return $q->fetchAll(PDO::FETCH_ASSOC);
		}

		public function find($where) 
		{
			return count($this->read($where)) > 0;
		}

		public function getAll($inicio, $limite) 
		{
			$query = "SELECT * FROM ".$this->nomeTabela;
			$query .= $this->getFilterText();
			
			if ($this->orderBy) {
				$query .= " ORDER BY ".$this->orderBy;
			}
			if ($limite) {
				$query .= " LIMIT $inicio, $limite";
			}			
			$stm = $this->db->prepare($query);			
			$stm->execute();
			$this->nrRegistros = $stm->rowCount();

			return $stm->fetchAll(PDO::FETCH_ASSOC);	//FETCH_OBJ
		}
	}
?>