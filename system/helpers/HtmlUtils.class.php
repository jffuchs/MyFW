<?php 
	class HtmlUtils 
	{
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

		//Cria o html dos títulos da table
		public static function TitulosTabela($colunas, $orderBy) 
		{
			$Aux = '';
            foreach ($colunas as $fieldName => $value)
            {
                if ($fieldName != "actions") {
                    $class = sprintf('<th class="header%s">', ($fieldName == $orderBy) ? " headerSortDown" : "");
                } else {
                    $class = '<th class="'.$value[2].'">';
                }
                $Aux .= $class.$value[0]."</th>";
            }
			return "<tr>$Aux</tr>";
		}

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

		//Cria os links html dos itens de menu
		//Expandir aqui pra mais níveis
		public static function MontarMenus($menus) 
		{
        	$aux = "";
        	foreach ($menus as $item) 
        	{
                $controller = $item[0];
            	$aux .= '<li '.activeMenu($controller).'><a href="'.PATH.$controller.'"><i class="fa fa-fw fa-'.$item[2].'"></i> '.$item[1].'</a></li>';
        	}
        	return $aux;
    	}

    	public static function MontarConfirmacao($tipo) 
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

    	public function MontarBreadCrumbs($ctrlActive, $nomeCtrl = NULL, $linkCtrl = NULL, $id = NULL) 
    	{
    		$aux = '<ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i> <a href="'.PATH.'">Home</a>
                            </li>';
            if (isset($nomeCtrl)) {
            	$aux .= '    <li>
                                <i class="fa fa-folder-open"></i> <a href="'.$linkCtrl.'">'.$nomeCtrl.'</a>
                             </li>';
            }

            $auxActive = isset($id) ? ($id > 0 ? 'Editar' : 'Incluir') : $ctrlActive;

            $aux .= '    <li class="active">
                             <i class="fa fa-folder-open"></i> '.$auxActive.'
                         </li>
                     </ol>';
            return $aux;
    	}
	}
?>