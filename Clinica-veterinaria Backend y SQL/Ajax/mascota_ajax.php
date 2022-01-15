<?php
    $peticion_ajax = True;
    require_once '../configuracion_servidor/aplicacion.php';
    /* Realizando una instancia al controlador */
    require_once '../controladores/mascota_controlador.php';

    /* Condicionales para registrar un dueño para la mascota */
    if(isset($_POST['buscar_cliente']) || isset($_POST['agregar_cliente_id']) || isset($_POST['eliminar_cliente_id']) || isset($_POST['mascota_nombre_reg']) || isset($_POST['mascota_vacuna_act'])){
        $instancia_cliente_mascota = new mascota_controlador();
        /* Verificar valor para la busqueda del propietario */
        if(isset($_POST['buscar_cliente'])){
            echo $instancia_cliente_mascota->buscar_cliente_controlador();
        }
        /* Agregar propietario para el registro de la mascota */
        if(isset($_POST['agregar_cliente_id'])){
            echo $instancia_cliente_mascota->agregar_cliente_controlador();
        }
        /* Eliminar propietario para el registro de la mascota */
        if(isset($_POST['eliminar_cliente_id'])){
            echo $instancia_cliente_mascota->eliminar_cliente_controlador();
        }
        /* Condicionales para la mascota */
        if(isset($_POST['mascota_nombre_reg'])){
            echo $instancia_cliente_mascota->agregar_mascota_controlador();
        }
        if(isset($_POST['mascota_vacuna_act'])){
            echo $instancia_cliente_mascota->actualizar_mascota_controlador();
        }
    }else{
        echo "Ha ocurrido un error al intentar realizar la busqueda";
    }