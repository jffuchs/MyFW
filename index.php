<?php
    require_once 'system/Config.php';
    require_once 'system/Router.php';
    require_once 'system/Controller.php';
    require_once 'system/Repository.php';
    require_once 'system/Model.php';

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

    $menus = new Menu();
    $menus->add('fornecedores', 'Fornecedores', 'table');
    $menus->add('cidades', 'Cidades', 'table');
    $menus->add(NULL, 'Relatórios', 'print', 'second',
                $menus->childs([$menus->createItem('', 'Fornecedores'),
                                $menus->createItem(NULL, 'Cidades', NULL, 'third',
                                                  $menus->childs([$menus->createItem('', 'por UF'),
                                                  $menus->createItem('', 'por CEP')]))]));
    $menus->add('usuario', 'Usuários', 'user');
    Session::set('menu', $menus->HTML());

    $start = new Router;
    $start->run();

    if (Session::getFrom('Login', 'Debug')) {
        echo '<pre>';
        print_r($_SESSION);
    }
?>
