<?php 
	class Data 
	{
		protected $ident;

		public function __construct($ident) 
		{
			$this->ident = $ident;
		}

		public function set($dados) 
		{
			Session::set($ident, $dados);
		}

		public function get() 
		{
			return Session::get($ident);
		}
	}
?>