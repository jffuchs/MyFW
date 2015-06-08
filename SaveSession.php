<?php      
    session_start();     

    $controller = $_GET['_controller'];

    if (isset($_GET['_linhas'])) {
        $_SESSION[$controller]['_linhas'] = $_GET['_linhas'];
    }  
    if (isset($_GET['_orderBy'])) {
        $_SESSION[$controller]['_orderBy'] = $_GET['_orderBy'];
    }
    if (isset($_GET['_orderAD'])) {
        $_SESSION[$controller]['_orderAD'] = $_GET['_orderAD'];
    }
    if (isset($_GET['_pesquisa'])) {
        $_SESSION[$controller]['_pesquisa'] = $_GET['_pesquisa'];
    }    
    if (isset($_GET['_filtros'])) {
        $_SESSION[$controller]['_filtros'] = $_GET['_filtros'];
    }

    //print_r(json_encode([['ID'=>777, 'Nome'=>'Jean Fabio Fuchs']]));
    print_r(json_encode(['result'=>$controller]));
?>
