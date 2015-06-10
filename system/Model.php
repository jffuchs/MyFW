<?php 
	class Model 
	{
		protected $db;
		protected $nomeTabela;		
		protected $nrRegistros;
		
		const NOME = "";
		const NOME_LISTA = "";		

		//--------------------------------------------------------------------------------------------		
		public function __construct($nomeTabela) 
		{
			$this->nomeTabela = $nomeTabela;
			$this->db = new PDO('mysql:host=localhost;dbname=phpbasico', 'root', '');
		}

		//-----------------------------------------------------------------------------------
		public function getRecordCountFromLastRead() 
		{
			return $this->nrRegistros;
		}

		public function getRecordCount($where = NULL) 
		{
			$query = "SELECT 1 FROM ".$this->nomeTabela;
			if ($where) {
				$query .= ' WHERE '.$where;
			}
			$sth = $this->db->query($query);
    		return $sth->rowCount();
		}

		//--------------------------------------------------------------------------------------------		
		public function insert(Array $dados) 
		{
			$campos = implode(", ", array_keys($dados));
			$valores = "'".implode("', '", array_values($dados))."'";

			$sql = "INSERT INTO {$this->nomeTabela} ({$campos}) VALUES ({$valores})";
			return $this->db->query($sql);
		}		

		//--------------------------------------------------------------------------------------------		
		public function update(Array $dados, $where = NULL) 
		{
			$where = ($where != NULL ? "WHERE {$where};" : "");

			foreach ($dados as $inds => $vals) 
			{
				$campos[] = "{$inds} = '{$vals}'";				
			}
			$campos = implode(", ", $campos);

			$sql = "UPDATE {$this->nomeTabela} SET {$campos} ".$where;
  			return $this->db->query($sql);
		}	

		//--------------------------------------------------------------------------------------------		
		public function delete($where = NULL) 
		{
			if ($where != NULL) {				
				$sql = "DELETE FROM {$this->nomeTabela} WHERE ".$where;
				return $this->db->query($sql);
			} else {
				return FALSE;
			}			
		}

		//--------------------------------------------------------------------------------------------		
		public function read($SQL = NULL, $where = NULL, $limit = null, $orderBy = NULL) 
		{			
			$where = ($where != NULL ? " WHERE {$where}" : "");
			$limit = ($limit != NULL ? " LIMIT {$limit}" : "");
			$orderBy = ($orderBy != NULL ? " ORDER BY {$orderBy}" : "");
			$comandoSQL = (!$SQL) ? "SELECT * FROM {$this->nomeTabela}" : $SQL;
			$comandoSQL = $comandoSQL.$where.$orderBy.$limit;
			$q = $this->db->query($comandoSQL);
			$this->nrRegistros = $q->rowCount();
			return $q->fetchAll(PDO::FETCH_ASSOC);
		}

		//--------------------------------------------------------------------------------------------		
		public function find($where) 
		{
			return count($this->read(NULL, $where)) > 0;
		}

		//--------------------------------------------------------------------------------------------		
		public function getAll($SQL, $inicio, $limite, $where, $orderBy = NULL, $orderAD = NULL) 
		{
			$orderBy = isset($orderBy) ? $orderBy.' '.$orderAD : NULL;
			return $this->read($SQL, $where, $inicio.', '.$limite, $orderBy);
		}
	}
?>