<?php
	class Redirect
	{
		//Redireciona para página HOME...
		public static function home()
		{
			header("location: ".PATH);
			exit;
		}

		//Redireciona para algum endereço dentro da aplicação...
		public static function to($path)
		{
			header("location:".$path);
			exit;
		}

		//Redireciona para algum site fora da aplicação...
		public static function toPath($path)
		{
			header("location: ".PATH.$path);
			exit;
		}

		public static function add($path, $arquivo)
		{
			if (file_exists($path.$arquivo)) {
				include $path.$arquivo;
			}
		}
	}
?>
