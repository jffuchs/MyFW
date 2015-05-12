<?php 
	class HtmlUtils 
	{
		//Monta um array com informações para serem usadas na mensagem de alerta
		public static function MontarAlerta($tipo = NULL, $msgDetalhe = NULL) 
		{
			$ret = NULL;
			if (isset($tipo)) 
			{
				switch ($tipo) 
				{
					case SALVO:
						$ret = array('titulo' => "Sucesso!", 
							         'msg' => "Dados foram salvos!", 
							         'class' => "success");
						break;
					case NAO_SALVO:
						$ret = array('titulo' => "Atenção!", 
							         'msg' => "Dados não foram salvos!", 
							         'class' => "warning");
						break;
					case EXCLUIDO:
						$ret = array('titulo' => "OK!", 
							         'msg' => "O registro que você selecionou foi excluído!", 
							         'class' => "success");
						break;
					case NAO_EXCLUIDO:
						$ret = array('titulo' => "Atenção!", 
							         'msg' => "O registro que você selecionou não foi excluído!", 
							         'class' => "warning");
						break;					
					case DADOS_INVALIDOS:
					 	$ret = array('titulo' => "ATENÇÃO!", 
							         'msg' => "Dados inválidos! Por favor verifique.", 
							         'class' => "warning");
						break;
					case NAO_ENCONTRADO:
					 	$ret = array('titulo' => "ERRO!", 
							         'msg' => "Registro não encontrado! Por favor verifique.", 
							         'class' => "danger");
						break;						
				}
				$ret["detalhe"] = $msgDetalhe;

				return $ret;
			}
		}

		//Cria o html da mensagem de alerta 
		public static function Alerta($msgAlerta) 
		{	
			if ($msgAlerta) 
			{
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
			foreach ($colunas as $fieldName => $fieldTitle) 
			{
				if ($fieldName != "actions") {
				  	$class = sprintf('<th class="header%s">', ($fieldName == $orderBy) ? " headerSortDown" : "");
				} else {
					$class = '<th class="col-xs-2">';
				}				
				$Aux .= $class.$fieldTitle."</th>";
			}			
			return "<tr>$Aux</tr>";
		}

		//Cria o html das colunas da table
		public static function CamposTabela($colunas) 
		{			
			$Aux = '';
			foreach ($colunas as $fieldName => $valor) 
			{
				if ($fieldName != "actions") {
					$Aux .= "<td>{".$fieldName."}</td>";
				}
			}			
			return $Aux;
		}

		//Cria os labels e inputs html para os campos que podem ser filtrados na table
		public static function CamposFiltros($filtros) 
		{
			$Aux = '';
			$arrayFiltros = $filtros;
        	for ($i=0; $i < count($arrayFiltros); $i++) 
        	{ 
        		$Aux .= '<div class="form-group">
                         <label>'.$arrayFiltros[$i][1].'</label>  
                         <input type="'.$arrayFiltros[$i][3].'" name="filtros[]" class="form-control">
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
            	$chave = key($item);
            	$aux .= '<li '.activeMenu($chave).'><a href="'.PATH.$chave.'">'.$item[$chave].'</a></li>';
        	}
        	return $aux;
    	}

    	public static function MontarConfirmacao($tipo) {
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
	}
?>