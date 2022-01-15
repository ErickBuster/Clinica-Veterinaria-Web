<?php
    function limpiar_cadena($cadena){
        $cadena = trim($cadena); // quita los espacios que esten antes o despues del texto
        $cadena = stripslashes($cadena); // quita las barras invertidas
        $cadena = str_ireplace('<script>', '', $cadena);
        $cadena = str_ireplace('</script>', '', $cadena);
        $cadena = str_ireplace('<script src>', '', $cadena);
        $cadena = str_ireplace('<script type>', '', $cadena);
        $cadena = str_ireplace('SELECT * FROM', '', $cadena);
        $cadena = str_ireplace('DELETE FROM', '', $cadena);
        $cadena = str_ireplace('INSERT INTO', '', $cadena);
        $cadena = str_ireplace('DROP TABLE', '', $cadena);
        $cadena = str_ireplace('DROP DATABASE', '', $cadena);
        $cadena = str_ireplace('TRUNCATE', '', $cadena);
        $cadena = str_ireplace('DATABASE()', '', $cadena);
        $cadena = str_ireplace('SHOW TABLES', '', $cadena);
        $cadena = str_ireplace('SHOW COLUMNS', '', $cadena);
        $cadena = str_ireplace('SHOW DATABASE()', '', $cadena);
        $cadena = str_ireplace('GROUP', '', $cadena);
        $cadena = str_ireplace('GROUPCONCAT', '', $cadena);
        $cadena = str_ireplace('<?php', '', $cadena);
        $cadena = str_ireplace('?>', '', $cadena);
        $cadena = str_ireplace('<', '', $cadena);
        $cadena = str_ireplace('>', '', $cadena);
        $cadena = str_ireplace('/', '', $cadena);
        $cadena = str_ireplace('--', '', $cadena);
        $cadena = str_ireplace(';', '', $cadena);
        $cadena = str_ireplace('{', '', $cadena);
        $cadena = str_ireplace('}', '', $cadena);
        $cadena = str_ireplace('(', '', $cadena);
        $cadena = str_ireplace(')', '', $cadena);
        $cadena = str_ireplace('[', '', $cadena);
        $cadena = str_ireplace(']', '', $cadena);
        $cadena = str_ireplace('^', '', $cadena);
        $cadena = str_ireplace('$', '', $cadena);
        $cadena = str_ireplace('==', '', $cadena);
        $cadena = str_ireplace('=', '', $cadena);
        $cadena = str_ireplace('"', '', $cadena);
        $cadena = str_ireplace("'", '', $cadena);
        $cadena = str_ireplace(":", '', $cadena);
        $cadena = str_ireplace("::", '', $cadena);
        $cadena = stripslashes($cadena); // quita las barras invertidas
        $cadena = trim($cadena); // quita los espacios que esten antes o despues del texto
        return $cadena;
    } 
    session_start(['name' => 'clinica_veterinaria']);
    require_once '../configuracion_servidor/aplicacion.php';
    /* llamadas de las paginas que contengas busqueda */
    if(isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda'])){
        $data_url = [
            'cliente' => 'cliente-buscar',
            'mascota' => 'mascota-buscar'
        ];
        /* verificando que sea correcto el nombre con el array */
        if(isset($_POST['modulo'])){
            $modulo = $_POST['modulo'];
            if(!isset($data_url[$modulo])){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error inesperado!',
                    'TEXTO' => 'No podemos continuar con la busqueda debido a ur error'
                ];
                echo json_encode($alerta);
                exit();
            }
        }else{
            $alerta = [
                'ALERTA' => 'simple',
                'ICONO' => 'error',
                'TITULO' => 'Ha ocurrido un error inesperado!',
                'TEXTO' => 'No podemos continuar con la busqueda debido a ur error de configuracion'
            ];
            echo json_encode($alerta);
            exit(); 
        }
        /* Condicionales del tipo de busqueda */
        $busqueda_var = 'busqueda_'.$modulo;
        /* busqueda inicial */
        if(isset($_POST['busqueda_inicial'])){
            if($_POST['busqueda_inicial'] == ''){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error inesperado!',
                    'TEXTO' => 'El campo de BUSQUEDA esta vacio, favor de introducir un termino de busqueda'
                ];
                echo json_encode($alerta);
                exit();
            }
            /* --- Funcion para segurisar las entradar (evita SQLinjection) --- */
            
            $_SESSION[$busqueda_var] = limpiar_cadena($_POST['busqueda_inicial']);
        }
        /* eliminar busqueda */
        if(isset($_POST['eliminar_busqueda'])){
            unset($_SESSION[$busqueda_var]);
        }
        /* redireccionar  */
        $url = $data_url[$modulo];
        $alerta = [
            'ALERTA' => 'redireccionar',
            'URL' => SERVERURL.$url.'/'
        ];
        echo json_encode($alerta);
    }
    else{
        header('Location: '.SERVERURL.'index/');
        exit();
    }