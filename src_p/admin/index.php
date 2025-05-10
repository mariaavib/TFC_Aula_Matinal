<?php
    require_once __DIR__ . "/app/config/config.php";

    if(!isset($_GET['c'])){
        $_GET['c'] = CONTR_DEF;
    }

    if(!isset($_GET['m'])){
        $_GET['m'] = METODO_DEF;
    }

    $rutaControlador = RUTA_CONTROLADOR.$_GET['c'].'.php';
    require_once($rutaControlador);
    $controlador='C'.$_GET['c'];
    $objControlador = new $controlador();
    $datos=[];

    if(method_exists($objControlador, $_GET['m'])){
        $datos = $objControlador -> {$_GET['m']}();
    }
    
    require_once(RUTA_VISTAS.$objControlador->vista.'.php');
?>