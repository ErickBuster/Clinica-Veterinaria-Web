<?php
    $peticion_ajax = True;
    require_once '../configuracion_servidor/aplicacion.php';

    if(isset($_POST['cliente_nombre_reg']) || isset($_POST['cliente_nombre_act'])){
        /* Realizando una instancia al controlador */
        require_once '../controladores/cliente_controlador.php';
        $instancia_cliente = new cliente_controlador();

        /* Verificar valor para registrar un cliente */
        if(isset($_POST['cliente_nombre_reg'])){
            echo $instancia_cliente->registrar_cliente_controlador();
        }elseif(isset($_POST['cliente_nombre_act'])){
            echo $instancia_cliente->actualizar_cliente_controlador();
        }
    }
    else{
        header('Location: '.SERVERURL.'index/');
        exit();
    }