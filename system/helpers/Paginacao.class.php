<?php
	class Paginacao
	{
		private $inicio = 0;
		private $limite = 0;
		private $paginaAtual = 0;
		private $totalPaginas = 0;
		private $totalRegistros = 0;

		public function __construct($value)
		{
			if (!$value) {
				$this->limite = 50;
			} else {
				$this->limite = (int)$value;
			}
		}

		public function getInicio()
		{
			return $this->inicio;
		}

		public function getLimite()
		{
			return $this->limite;
		}

		public function getPaginaAtual()
		{
			return $this->paginaAtual;
		}

		public function getTotalPaginas()
		{
			return $this->totalPaginas;
		}

		public function setPaginaAtual($value = 0)
		{
			$this->paginaAtual = (int)$value;
			$this->paginaAtual = filter_var($this->paginaAtual, FILTER_VALIDATE_INT);
			$this->inicio = ($this->paginaAtual * $this->limite) - $this->limite;
			if ($this->inicio < 0) {
				$this->inicio = 0;
			}
		}

		public function setTotalRegistros($value)
		{
			$this->totalRegistros = (int)$value;
			$this->totalPaginas = Ceil($this->totalRegistros / $this->limite);
		}

		public function htmlPaginacao($paginaList)
		{
			$pagAnt = ($this->paginaAtual == 1) ? 1 : $this->paginaAtual-1;
			$proxPag = ($this->paginaAtual == $this->totalPaginas) ? $this->totalPaginas : $this->paginaAtual+1;

			$disabledFirst = ($this->paginaAtual == 1) ? "disabled" : NULL;
			$disabledLast = ($this->paginaAtual == $this->totalPaginas) ? "disabled" : NULL;

			$listaPaginas = '<ul class="pagination center-block">';
			$listaPaginas .= '<li><a class="back-to-top" href="#top"><i class="fa fa-arrow-up"></i></a></li>';
			$listaPaginas .= '<li class="'.$disabledFirst.'">
				      		      <a href="'.$paginaList.'/index/pag/'.$pagAnt.'"
								      aria-label="Previous"><span aria-hidden="true">&laquo;</span>
						      	  </a>
						 	  </li>';

			// Number of page links in the begin and end of whole range
			$count_out = 3;
			// Number of page links on each side of current page
			$count_in = 2;
			// Beginning group of pages: $n1...$n2
			$n1 = 1;
			$n2 = min($count_out, $this->totalPaginas);
			// Ending group of pages: $n7...$n8
			$n7 = max(1, $this->totalPaginas - $count_out + 1);
			$n8 = $this->totalPaginas;
			// Middle group of pages: $n4...$n5
			$n4 = max($n2 + 1, $this->paginaAtual - $count_in);
			$n5 = min($n7 - 1, $this->paginaAtual + $count_in);
			$use_middle = ($n5 >= $n4);
			// Point $n3 between $n2 and $n4
			$n3 = (int) (($n2 + $n4) / 2);
			$use_n3 = ($use_middle && (($n4 - $n2) > 1));
			// Point $n6 between $n5 and $n7
			$n6 = (int) (($n5 + $n7) / 2);
			$use_n6 = ($use_middle && (($n7 - $n5) > 1));
			// Links to display as array(page => content)

			$links = array();

			for ($i = $n1; $i <= $n2; $i++) $links[$i] = $i;

			if ($use_n3) $links[$n3] = '...';

			for ($i = $n4; $i <= $n5; $i++) $links[$i] = $i;

			if ($use_n6) $links[$n6] = '...';

			for ($i = $n7; $i <= $n8; $i++)	$links[$i] = $i;

			foreach ($links as $number => $content) {
				$classe = ($number == $this->paginaAtual) ? ' class="active"' : NULL;
    			$listaPaginas .= '<li'.$classe.'><a href="'.$paginaList.'/index/pag/'.$number.'"> '.$content.'</a></li>';
			}

			$listaPaginas .= '<li class="'.$disabledLast.'">
						  	      <a href="'.$paginaList.'/index/pag/'.$proxPag.'"
						  	          aria-label="Next"><span aria-hidden="true">&raquo;</span>
						          </a>
						      </li>';
			$listaPaginas .= '</ul>';

			return $listaPaginas;
		}
	}
?>
