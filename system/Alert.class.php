<?php
	class Alert
	{
		//Monta um array com informações para serem usadas na mensagem de alerta
		private function build($tipo = NULL, $msgDetalhe = NULL)
		{
			$ret = NULL;
			if (isset($tipo)) {
				switch ($tipo)	{
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

		public static function set($tipo, $msg = NULL)
		{
			Session::set(MSG_ALERTAS, self::build($tipo, $msg));
		}

		public static function get()
		{
			return Session::get(MSG_ALERTAS);
		}

		public static function clear()
		{
			Session::set(MSG_ALERTAS, NULL);
		}

		public static function render()
		{
			return HtmlUtils::Alerta(self::get());
		}
	}
?>
