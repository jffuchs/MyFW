<?php
	class Menu
	{
		protected $lista;

		public function __construct()
		{
			$this->lista = array();
		}

		//-------------------------------------------------------------------------------------------------------
		public function createItem($link, $caption, $icon = NULL, $level = NULL, $childs = NULL)
		{
			return array($link, $caption, $icon, $level, $childs);
		}

		//-------------------------------------------------------------------------------------------------------
		public function add($link, $caption, $icon = NULL, $level = NULL, $childs = NULL)
		{
			$aux = $this->createItem($link, $caption, $icon, $level, $childs);
			$this->lista[] = $aux;
			return $aux;
		}

		//-------------------------------------------------------------------------------------------------------
		public function childs($childs)
		{
			return $childs;
		}

		//-------------------------------------------------------------------------------------------------------
		public function isActiveMenu($menu)
		{
        	$aux = isset($_GET) ? implode("/", $_GET) : "";
        	if (!$menu) {
        		return NULL;
        	}
        	return (strpos($aux, $menu) === 0) ? 'class="active"' : NULL;
    	}

    	//-------------------------------------------------------------------------------------------------------
    	public function pathMenu($menu)
    	{
    		return ($menu) ? PATH.$menu : '#';
    	}

    	//-------------------------------------------------------------------------------------------------------
		public function HTML($lista = NULL)
		{
			$aux = "";

			if (!isset($lista)) {
				$lista = $this->lista;
			}

		    foreach ($lista as $itemMenu => $item)
		    {
		        $childs = $item[4];
		        $controller = $item[0];

		        if (is_array($childs)) {
		            $aux .= '<li><a href="#"><i class="fa fa-'.$item[2].' fa-fw"></i> '.$item[1].'<span class="fa arrow"></span></a>';
		            $aux .= '<ul class="nav nav-'.$item[3].'-level">'.$this->HTML($childs).'</ul></li>';
		        } else {
		            $aux .= '<li '.$this->isActiveMenu($controller).'><a href="'.$this->pathMenu($controller).'">
		            		 <i class="fa fa-fw fa-'.$item[2].'"></i> '.$item[1].'</a></li>';

		            //Com ajax...
		           	/*$sctrl = "'$controller'";
		           	$aux .= '<li '.$this->isActiveMenu($controller).' onclick="changeController('.$sctrl.');"><a href="javascript:void(0);">
		            		 <i class="fa fa-fw fa-'.$item[2].'"></i> '.$item[1].'</a></li>';*/
		        }
		    }
		    return $aux;
		}
	}
?>
