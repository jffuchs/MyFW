<?php
    session_start();

    $_SESSION['UsuarioID'] = 0;
    $_SESSION['UsuarioNome'] = 'JEAN';

    define('PATH', '/TESTE/');
    define('PATH_PUBLIC', '/TESTE/public/');

    define('CONTROLLERS', 'app/controllers/');
    define('VIEWS', 'app/views/');
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

    require_once 'system/Session.php';
    require_once 'system/system.php';
    require_once 'system/Controller.php';
    require_once 'system/Model.php';

    function __autoload($file) 
    {
        if (file_exists(MODELS.$file.'.php')) {
            require_once(MODELS.$file.'.php');
        } elseif (file_exists(HELPERS.$file.'.php')) {
            require_once(HELPERS.$file.'.php');
        } elseif (file_exists(HELPERS.$file.'.class.php')) {
            require_once(HELPERS.$file.'.class.php');
        }        
    }

    include VIEWS.'index.phtml';

    $start = new System;
    $start->run();
?>