<?php
    require_once 'system/Config.php';
    require_once 'system/Router.php';
    require_once 'system/Controller.php';
    require_once 'system/Repository.php';
    require_once 'system/Model.php';

    $nomeController = Request::post('_controller');

    function __autoload($nomeController)
    {
        if (file_exists(MODELS.$nomeController.'.php')) {
            require_once(MODELS.$nomeController.'.php');
        } elseif (file_exists(REPOSITORIES.$nomeController.'.php')) {
            require_once(REPOSITORIES.$nomeController.'.php');
        } elseif (file_exists(HELPERS.$nomeController.'.php')) {
            require_once(HELPERS.$nomeController.'.php');
        } elseif (file_exists(HELPERS.$nomeController.'.class.php')) {
            require_once(HELPERS.$nomeController.'.class.php');
        } else {
            Warning::page404("Arquivo <strong>{$nomeController}</strong> não encontrado!");
            exit;
        }
    }

    Session::init();

    //-------------------------
    $controller_path = CONTROLLERS.$nomeController.'Controller.php';
    if (!file_exists($controller_path)) {
        Warning::page404("Arquivo de controller <b>{$controller_path}</b> não encontrado!");
        exit;
    }
    require_once($controller_path);
    $app = new $nomeController();
    //-------------------------

    if (Request::post('_linhas')) {
        Session::setPlus($nomeController, '_linhas', Request::post('_linhas'));
    }
    if (Request::post('_orderBy')) {
        Session::setPlus($nomeController, '_orderBy', Request::post('_orderBy'));
    }
    if (Request::post('_orderAD')) {
        Session::setPlus($nomeController, '_orderAD', Request::post('_orderAD'));
    }
    $page = (int)Request::post('page');
    if ($page) {
        Session::setPlus($nomeController, 'actualPage', $page);
    } else {
        $page = 1;
    }
    $pesquisa = Request::post('_pesquisa');
    if (isset($pesquisa)) {
        Session::setPlus($nomeController, '_pesquisa', $pesquisa);
    }

	$pagina = new PaginaLista($app->repository->model, $app);
	$pagina->setPaginaAtual($page);
	$pagina->setPath(PATH.$nomeController);

	echo $pagina->show();
?>
