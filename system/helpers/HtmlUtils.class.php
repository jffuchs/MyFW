<?php
	class HtmlUtils
	{
        //---------------------------------------------------------------------------------------------
		//Cria o html da mensagem de alerta
		public static function Alerta($msgAlerta)
		{
			if ($msgAlerta) {
				$Aux = '<div class="alert alert-'.$msgAlerta["class"].' "alert-dismissible" role="alert">
			    	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<strong>'.$msgAlerta["titulo"].'</strong> '.$msgAlerta["msg"];
			    $Aux .= isset($msgAlerta["detalhe"]) ? '<br />'.$msgAlerta["detalhe"] : "";
			    $Aux .= '</div>';
				return $Aux;
			}
			return NULL;
		}

        //---------------------------------------------------------------------------------------------
		//Cria o html dos títulos da table
		public static function TitulosTabela($colunas, $orderBy, $path, $orderAD = 'ASC')
		{
			$Aux = '';
            foreach ($colunas as $fieldName => $value)
            {
                $desc = ($orderAD == 'DESC') ? 'headerSortUp' : 'headerSortDown';
                if ($fieldName != "actions") {
                    $class = sprintf(' class="header%s"', ($fieldName == $orderBy) ? " $desc" : "").' onclick="changeTableOrder('.$fieldName.')"';
                } else {
                    $class = '';
                }
                $Aux .= '<th'.$class.' data_aux="'.$orderAD.'" id="'.$fieldName.'">'.$value[0].'</th>';
            }
			return "<tr>$Aux</tr>";
		}

        //---------------------------------------------------------------------------------------------
		//Cria o html das colunas da table
		public static function CamposTabela($colunas)
		{
			$Aux = '';
			foreach ($colunas as $fieldName => $value)
            {
                if ($fieldName != "actions") {
                    $Aux .= '<td align="'.$value[3].'">{'.$fieldName.'}</td>';
                }
            }
			return $Aux;
		}

        //---------------------------------------------------------------------------------------------
		//Cria os labels e inputs html para os campos que podem ser filtrados na table
		public static function CamposFiltros($filtros)
		{
			$Aux = '';
            foreach($filtros as $key => $value)
            {
                $Aux .= '<div class="form-group">
                         <label>'.$filtros[$key][0].'</label>
                         <input type="'.$filtros[$key][2].'" name="filtros[]" class="form-control"
                         value="'.$filtros[$key][3].'">
                         </div>';
            }
        	return $Aux;
		}

        //---------------------------------------------------------------------------------------------
		//Cria os links html dos itens de menu
		//Expandir aqui pra mais níveis
		public static function Menus($menus)
		{
        	/*$aux = "";
        	foreach ($menus as $item)
        	{
                $controller = $item[0];
                if (is_array($controller)) {
                    $aux .= '<li><a href="#"><i class="fa fa-print fa-fw"></i> '.$item[1].'<span class="fa arrow"></span></a>';
                    $aux .= '<ul class="nav nav-second-level">';
                    $aux .= self::Menus($controller);
                    $aux .= '</ul></li>';
                } else {
                    $aux .= '<li '.activeMenu($controller).'><a href="'.PATH.$controller.'"><i class="fa fa-fw fa-'.$item[2].'"></i> '.$item[1].'</a></li>';
                }
        	}
        	return $aux;*/


            $aux = "";
            foreach ($menus as $item)
            {
                $controller = $item[0];

var_export($controller);

                if (is_array($controller)) {
                    $aux .= '<li><a href="#"><i class="fa fa-print fa-fw"></i> '.$item[1].'<span class="fa arrow"></span></a>';
                    $aux .= '<ul class="nav nav-second-level">';
                    $aux .= self::Menus($controller);
                    $aux .= '</ul></li>';
                } else {
                    $aux .= '<li '.activeMenu($controller).'><a href="'.PATH.$controller.'"><i class="fa fa-fw fa-'.$item[2].'"></i> '.$item[1].'</a></li>';
                }
            }
            return $aux;
    	}

        //---------------------------------------------------------------------------------------------
    	public static function Confirmacao($tipo)
    	{
    		$aux = '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                		<h4 class="modal-title" id="myModalLabel">'.$tipo[0].'</h4>
					</div>
            		<div class="modal-body">
            			<p><strong>ATENÇÃO</strong></p>
            			<p>'.$tipo[1].'</p>
                		<p class="debug-url"></p>
					</div>

            		<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                		<a class="btn btn-'.$tipo[2].' btn-ok">'.$tipo[3].'</a>
					</div>
					</div>
					</div>
					</div>';
			return $aux;
    	}

        //---------------------------------------------------------------------------------------------
    	public function BreadCrumbs($ctrlActive, $nomeCtrl = NULL, $linkCtrl = NULL, $id = NULL)
    	{
    		$aux = '<ol class="breadcrumb"><li><i class="fa fa-home"></i> <a href="'.PATH.'">Home</a></li>';
            if (isset($nomeCtrl)) {
            	$aux .= '<li><i class="fa fa-folder-open"></i> <a href="'.$linkCtrl.'">'.$nomeCtrl.'</a></li>';
            }
            $auxActive = isset($id) ? ($id > 0 ? 'Editar' : 'Incluir') : $ctrlActive;
            $aux .= '<li class="active"><i class="fa fa-folder-open"></i> '.$auxActive.'</li></ol>';
            return $aux;
    	}

        //---------------------------------------------------------------------------------------------
        public function OpcoesLinhasTable($selected)
        {
            $lista = array(10,15,20,50,100);
            $aux = '';
            for ($i=0; $i < count($lista); $i++)
            {
                $sel = ($lista[$i] == $selected) ? ' selected="selected"' : '';
                $aux .= '<option value="'.$lista[$i].'"'.$sel.'>'.$lista[$i].'</option>';
            }
            return $aux;
        }
	}
?>
