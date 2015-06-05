<?php
    define('PATH', '/TESTE/');
    define('PATH_PUBLIC', '/TESTE/public/');

    define('ROOT', dirname(dirname(__FILE__)));

    define('CONTROLLERS', 'app/controllers/');
    define('VIEWS', 'app/views/');
    define('REPOSITORIES', 'app/repositories/');
    define('MODELS', 'app/models/');
    define('HELPERS', 'system/helpers/');

    define('SALVO', 'salvo');
    define('NAO_SALVO', 'nao-salvo');
    define('EXCLUIDO', 'excluido');
    define('NAO_EXCLUIDO', 'nao-excluido');
    define('NAO_ENCONTRADO', 'nao-encontrado');
    define('DADOS_INVALIDOS', 'dados-invalidos');

    define('ACAO', 'acao');
    define('ACAO_INCLUIR', 'incluir');
    define('ACAO_EDITAR', 'editar');
    define('MSG_ALERTAS', 'alertaMsg');
    define('DADOS_CACHE', 'dadosCache');    

    require_once 'system/Warning.php';
    require_once 'system/Session.php';
    require_once 'system/Request.php';    
    require_once 'system/Redirect.php';
    require_once 'system/Router.php';
    require_once 'system/Data.class.php';
    require_once 'system/Filter.php';
    require_once 'system/Columns.php';
    require_once 'system/Controller.php';
    require_once 'system/Repository.php';
    require_once 'system/Model.php';
    require_once 'system/Alert.class.php';    

    function __autoload($file) 
    {
        if (file_exists(MODELS.$file.'.php')) {
            require_once(MODELS.$file.'.php');
        } elseif (file_exists(REPOSITORIES.$file.'.php')) {
            require_once(REPOSITORIES.$file.'.php');
        } elseif (file_exists(HELPERS.$file.'.php')) {
            require_once(HELPERS.$file.'.php');
        } elseif (file_exists(HELPERS.$file.'.class.php')) {
            require_once(HELPERS.$file.'.class.php');
        } else {
            Warning::page404("Arquivo <strong>{$file}</strong> não encontrado!");
            exit;
        }      
    }

    Session::init();
    Session::set('UsuarioID', 0);
    Session::set('UsuarioNome', 'jffuchs');
    //Session::set('_orderBy', 'ID');    

    if (file_exists(VIEWS.'index.phtml')) {
        include VIEWS.'index.phtml';
    } else {
        Warning::page404("Arquivo <strong>".VIEWS."index.phtml</strong> não encontrado!");
        exit;
    }

    $start = new Router;
    $start->run();
?>