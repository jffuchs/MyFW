<?php      
    session_start(); 

    if (isset($_GET['_linhas'])) {
        $_SESSION['_linhas'] = $_GET['_linhas'];
    }  
    if (isset($_GET['_orderBy'])) {
        $_SESSION['_orderBy'] = $_GET['_orderBy'];
    }
    if (isset($_GET['_orderAD'])) {
        $_SESSION['_orderAD'] = $_GET['_orderAD'];
    }

    //print_r(json_encode([['ID'=>777, 'Nome'=>'Jean Fabio Fuchs']]));
    print_r(json_encode(['OK']));
?>
