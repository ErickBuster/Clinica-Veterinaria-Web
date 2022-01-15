<?php
    /* Verificando si hay una peticion Ajax */
    if($peticion_ajax){
        require_once '../modelos/mascota_modelo.php';
    }else{
        require_once './modelos/mascota_modelo.php';
    }

    /* Clase controlador para las mascotas */
    class mascota_controlador extends mascota_modelo{
        /* --- Funcion controlador para buscar un propietario para la mascota --- */
        public function buscar_cliente_controlador(){
            $cliente = main_modelo::limpiar_cadena($_POST['buscar_cliente']);

            /* comprobando que no este vacio */
            if($cliente == ''){
                return '<div class="fallo p-3" role="alert">
                    <p class="text-center mb-0 text-shadow">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        El campo de BUSQUEDA esta vacio, favor de introducir un (NOMBRE, CORREO, TELEFONO)
                    </p>
                </div>';
                exit();
            }

            /* Buscando el cliente en la base de datos */
            $datos_cliente = main_modelo::ejecutar_consulta_simple("SELECT cliente_nombre,cliente_id FROM cliente WHERE cliente_nombre LIKE '%$cliente%' OR cliente_correo LIKE '%$cliente%' OR cliente_celular LIKE '%$cliente%' OR cliente_telefono LIKE '%$cliente%' ORDER BY cliente_nombre ASC");

            if($datos_cliente->rowCount() > 0){
                $datos_cliente = $datos_cliente->fetchAll();
                /* Creando la tabla de resultados (Inicio) */
                $tabla = '<div class="table-responsive">
                    <table class="table table-hover table-bordered table-sm">
                        <tbody>';
                
                foreach($datos_cliente as $dato){
                        $tabla .= '<tr class="text-center">
                            <td>'.$dato['cliente_nombre'].'</td>
                            <td>
                                <button type="button" class="btn btn-agregar" onclick = "agregar_cliente_mascota('.$dato['cliente_id'].')"><i class="fas fa-user-plus"></i></button>
                            </td>
                        </tr>';
                    }

                /* Fin de la tabla */    
                $tabla .= '</tbody></table></div>';
                return $tabla;
            }else{
                return '<div class="fallo p-3" role="alert">
                    <p class="text-center mb-0 text-shadow">
                        <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                        No hemos encontrado ningún cliente en el sistema que coincida con <strong>“'.$cliente.'”</strong> 
                    </p>
                </div>';
                exit();

            }
            echo "Hola mundo";
        } /* --- Fin de la funcion --- */

        /* --- Funcion controlador para agregar un propietario para la mascota --- */
        public function agregar_cliente_controlador(){
            $cliente_id = main_modelo::limpiar_cadena($_POST['agregar_cliente_id']);

            /* Comprobando el cliente en el sistema */
            $check_cliente = main_modelo::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id = '$cliente_id'");
            if($check_cliente->rowCount() > 0){
                $datos = $check_cliente->fetch();
            }else{
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'El DUEÑO no existe en el sistema, favor de intentarlo nuevamente'
                ];
                echo json_encode($alerta);
                exit();
            }

            /* Creacion una session para el dato seleccionado */
            session_start(['name' => 'clinica_veterinaria']);
            if(empty($_SESSION['datos_cliente'])){
                $_SESSION['datos_cliente'] = [
                    'ID' => $datos['cliente_id'],
                    'NOMBRE' => $datos['cliente_nombre'],
                    'DIRECCION' => $datos['cliente_direccion'],
                    'CORREO' => $datos['cliente_correo'],
                    'CELULAR' => $datos['cliente_celular'],
                    'TELEFONO' => $datos['cliente_telefono']
                ];
                $alerta = [
                    'ALERTA' => 'recargar',
                    'ICONO' => 'success',
                    'TITULO' => 'Completado!',
                    'TEXTO' => 'Se ha agregado el DUEÑO para la mascota'
                ];
            }else{
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'No hemos podido agregar el DUEÑO, favor de intentarlo nuevamente'
                ];
            }
            echo json_encode($alerta);
        } /* --- Fin de la funcion --- */

        /* --- Funcion controlador para eliminar un propietario para la mascota --- */
        public static function eliminar_cliente_controlador(){
            /* iniciando la sesion */
            session_start(['name' => 'clinica_veterinaria']);
            unset($_SESSION['datos_cliente']);

            if(empty($_SESSION['datos_cliente'])){
                $alerta = [
                    'ALERTA' => 'recargar',
                    'ICONO' => 'success',
                    'TITULO' => 'Completado!',
                    'TEXTO' => 'Se ha eliminado el DUEÑO para la mascota'
                ];
            }else{
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'No hemos podido eliminar el DUEÑO, favor de intentarlo nuevamente'
                ];
            }
            echo json_encode($alerta);
        } /* --- Fin de la funcion --- */

        /* --- Funcion controlador para registrar una mascota --- */
        public function agregar_mascota_controlador(){
            /* Comprobando que haya un dueño para la mascota */
            session_start(['name' => 'clinica_veterinaria']);
            if(empty($_SESSION['datos_cliente'])){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'Favor de seleccionar un DUEÑO para poder registrar a la MASCOTA'
                ];
                echo json_encode($alerta);
                exit();
            }
            /* Comprobando que el dueño existe en el sistema */
            $propietario = $_SESSION['datos_cliente']['NOMBRE'];
            $check_cliente = main_modelo::ejecutar_consulta_simple("SELECT cliente_nombre FROM cliente WHERE cliente_nombre = '$propietario'");
            if($check_cliente->rowCount() <= 0){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'El DUEÑO no existe en el sistema, favor de elegir un nuevo DUEÑO'
                ];
                echo json_encode($alerta);
            }
            
            $nombre = main_modelo::limpiar_cadena($_POST['mascota_nombre_reg']);
            $raza = main_modelo::limpiar_cadena($_POST['mascota_raza_reg']);
            $sexo = main_modelo::limpiar_cadena($_POST['mascota_sexo_reg']);
            $nacimiento = main_modelo::limpiar_cadena($_POST['mascota_fecha_nacimiento_reg']);
            $muerte = main_modelo::limpiar_cadena($_POST['mascota_fecha_muerte_reg']);
            $vacuna = main_modelo::limpiar_cadena($_POST['mascota_vacuna_reg']);

            /* Comprobando los datos obligatorios */
            if($nombre == '' || $raza == '' || $sexo == '' || $vacuna == ''){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'No has llenado todos los datos obligatorios (NOMBRE - RAZA - SEXO - VACUNAS)'
                ];
                echo json_encode($alerta);
                exit();
            }

            /* Verificando los datos con los patterns correspondientes */
            if(main_modelo::verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}', $nombre)){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'El NOMBRE ingresado no corresponde con el formato solicitado'
                ];
                echo json_encode($alerta);
                exit();
            }if(main_modelo::verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}', $raza)){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'La RAZA ingresada no corresponde con el formato solicitado'
                ];
                echo json_encode($alerta);
                exit();
            }if($sexo != 'Macho' && $sexo != 'Hembra'){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'El SEXO ingresado no corresponde con el formato solicitado'
                ];
                echo json_encode($alerta);
                exit();
            }if($nacimiento != ''){
                if(main_modelo::verificar_fechas($nacimiento)){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'La FECHA DE NACIMIENTO ingresado no corresponde con el formato solicitado'
                    ];
                    echo json_encode($alerta);
                    exit();
                }if(date('Y-m-d') < $nacimiento){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'La FECHA DE NACIMIENTO ingresado es mayor a la fecha de hoy, favor de comprobar el campo'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }if($muerte != ''){
                if(main_modelo::verificar_fechas($muerte)){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'La FECHA DE MUERTE ingresado no corresponde con el formato solicitado'
                    ];
                    echo json_encode($alerta);
                    exit();
                }if(date('Y-m-d') < $muerte){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'La FECHA DE MUERTE ingresado es mayor a la fecha de hoy, favor de comprobar el campo'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }if($nacimiento != '' && $muerte != ''){
                if($nacimiento > $muerte){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'La FECHA DE NACIMEINTO es mayor a la FECHA DE MUERTE, favor de comprobar el campo'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }if(main_modelo::verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,200}',$vacuna)){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'Las VACUNAS ingresadas no corresponde con el formato solicitado'
                ];
                echo json_encode($alerta);
                exit();
            }
            $check_nombre_mascota = main_modelo::ejecutar_consulta_simple("SELECT mascota_propietario FROM mascota WHERE mascota_nombre = '$nombre' AND mascota_propietario = '$propietario'");
            if($check_nombre_mascota->rowCount() > 0){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'El NOMBRE DE LA MASCOTA ya existe para el dueño '.$propietario.' favor de usar otro nombre diferente para la mascota'
                ];
                echo json_encode($alerta);
                exit();
            }

            /* Preparando datos */
            $datos = [
                'NOMBRE' => $nombre,
                'PROPIETARIO' => $propietario,
                'RAZA' => $raza,
                'SEXO' => $sexo,
                'NACIMIENTO' => $nacimiento,
                'MUERTE' => $muerte,
                'VACUNA' => $vacuna
            ];
            $registrar_mascota = mascota_modelo::agregar_mascota_modelo($datos);
            if($registrar_mascota->rowCount() == 1){
                $alerta = [
                    'ALERTA' => 'recargar',
                    'ICONO' => 'success',
                    'TITULO' => 'MASCOTA REGISTRADO!',
                    'TEXTO' => 'La MASCOTA se ha registrado correctamente al sistema'
                ];
            }else{
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'Hubo un error al registrar la MASCOTA al sistema'
                ];
            }
            echo json_encode($alerta);
        } /* --- Fin de la funcion --- */

        /* --- Funcion controlador para mostrar las mascotas --- */
        public function lista_mascota_controlador($pagina_actual, $numero_registros, $url, $busqueda){
            $pagina_actual = main_modelo::limpiar_cadena($pagina_actual);
            $numero_registros = main_modelo::limpiar_cadena($numero_registros);

            $url = main_modelo::limpiar_cadena($url);
            $url = SERVERURL.$url.'/';

            $busqueda = main_modelo::limpiar_cadena($busqueda);

            $tabla = '';

            $pagina_actual = (isset($pagina_actual) && $pagina_actual > 0) ? (int)$pagina_actual : 1;
            $inicio = ($pagina_actual > 0) ? (($pagina_actual * $numero_registros) - $numero_registros) : 0;

            /* Realizando busquedas */
            if(isset($busqueda) && $busqueda != ''){
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM mascota JOIN cliente ON cliente.cliente_nombre = mascota.mascota_propietario WHERE mascota.mascota_nombre LIKE '%$busqueda%' OR mascota.mascota_propietario LIKE '%$busqueda%' OR cliente.cliente_correo LIKE '%$busqueda%' ORDER BY mascota.mascota_nombre ASC LIMIT $inicio, $numero_registros";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM mascota ORDER BY mascota_nombre ASC LIMIT $inicio, $numero_registros";
            }
            $coneccion = main_modelo::coneccion_db();
            $datos = $coneccion->query($consulta);
            $datos = $datos->fetchAll();

            /* Calculando todos los datos en el sistema */
            $datos_total = $coneccion->query("SELECT FOUND_ROWS()");
            $datos_total = (int)$datos_total->fetchColumn();

            /* Alamcenando el numero total de paginas */
            $numero_paginas = ceil($datos_total / $numero_registros);

            /* Creando el formato de tabla */
                /* Inicio de la tabla */
            $tabla .= '<div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr class="text-center" style="background-color: #FFC269">
                            <th>#</th>
                            <th>NOMBRE MASCOTA</th>
                            <th>PROPIETARIO</th>
                            <th>VACUNAS</th>
                            <th>RAZA</th>
                            <th>SEXO</th>
                            <th>FECHAS</th>
                            <th>ACTUALIZAR</th>
                        </tr>
                    </thead>
                    <tbody class = "tabla-style">';
            
            if($datos_total > 0 && $pagina_actual <= $numero_paginas){
                $contador = $inicio + 1;
                /* Mostrandor los datos de la consulta anterior */
                foreach($datos as $dato){
                    /* tabla */
                    $tabla .= '<tr class="text-center">
                        <td>'.$contador.'</td>
                        <td>'.$dato['mascota_nombre'].'</td>
                        <td>'.$dato['mascota_propietario'].'</td>
                        <td>'.$dato['mascota_vacuna'].'</td>
                        <td>'.$dato['mascota_raza'].'</td>
                        <td>'.$dato['mascota_sexo'].'</td>
                        <td>
                            <button type="button" class="btn btn-detalle" data-bs-toggle="popover" data-bs-trigger="hover" title="'.$dato['mascota_nombre'].'" data-bs-content="Fecha de nacimineto: '.$dato['mascota_nacimiento'].'  Fecha de muerte: '.$dato['mascota_muerte'].'">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </td>
                        <td>
                        <a href="'.SERVERURL.'mascota-actualizar/'.main_modelo::cifrar($dato['mascota_id']).'" class="btn btn-actualizar">
                        <i class="fas fa-sync-alt"></i>	
                        </a>
                        </td>
                    </tr>';
                    $contador++;
                }
            }else{
                if($datos_total > 0){
                    $tabla .= '<tr class="text-center"><td colspan = "9">
                    <a href = "'.$url.'" class = "btn btn-raised btn-warning btn-sm">Haga click para recargar el listado</a>
                    </td></tr>';
                }else{
                    $tabla .= '<tr class="text-center" ><td colspan = "9"> No hay registros en el sistema</td></tr>';
                }
            }
            /* Fin de la tabla */
            $tabla .= '</tbody></table></div>';
            /* Agregando la botonera de navegacion */
            if($datos_total > 0 && $pagina_actual <= $numero_paginas){
                $numero_botones = 3;
                $tabla .= main_modelo::paginar_tablas($pagina_actual, $numero_paginas, $url, $numero_botones);
            }
            return $tabla;
        } /* --- Fin de la funcion --- */

        /* --- Funcion controlador para obtener los datos de la mascota --- */
        public function datos_mascota_controlador($id_mascota){
            $id_mascota = main_modelo::descifrar($id_mascota);
            $id_mascota = main_modelo::limpiar_cadena($id_mascota);

            return mascota_modelo::datos_mascota_modelo($id_mascota);
        }

        /* --- Funcion controlador para actualizar la mascota --- */
        public function actualizar_mascota_controlador(){
            $id_mascota = main_modelo::descifrar($_POST['mascota_id_act']);
            $id_mascota = main_modelo::limpiar_cadena($id_mascota);
            $muerte = main_modelo::limpiar_cadena($_POST['mascota_fecha_muerte_act']);
            $vacuna = main_modelo::limpiar_cadena($_POST['mascota_vacuna_act']);

            /* Comprobando que la mascota exista en el sistema */
            $datos_mascota = mascota_modelo::datos_mascota_modelo($id_mascota);
            if($datos_mascota->rowCount() <= 0){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'La MASCOTA que intentas actualizar no existe en el sistema'
                ];
                echo json_encode($alerta);
                exit();
            }
            $datos_mascota = $datos_mascota->fetch();
            /* Comprobando los datos obligatorios */
            if($vacuna == ''){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'No has llenado el campo obligatorio (VACUNAS)'
                ];
                echo json_encode($alerta);
                exit();
            }
            /* Comprobando los datos con los patterns correspondientes */
            if(main_modelo::verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,200}',$vacuna)){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'Las VACUNAS ingresadas no corresponde con el formato solicitado'
                ];
                echo json_encode($alerta);
                exit();
            }
            /* comprobando el campo de fecha de muerte */
            if($muerte != ''){
                if(main_modelo::verificar_fechas($muerte)){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'La FECHA DE MUERTE ingresado no corresponde con el formato solicitado'
                    ];
                    echo json_encode($alerta);
                    exit();
                }if(date('Y-m-d') < $muerte){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'La FECHA DE MUERTE ingresado es mayor a la fecha de hoy, favor de comprobar el campo'
                    ];
                    echo json_encode($alerta);
                    exit();
                }if($datos_mascota['mascota_nacimiento'] > $muerte){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'La FECHA DE NACIMEINTO es mayor a la FECHA DE MUERTE, favor de comprobar el campo'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
            $datos_actualizar = [
                'VACUNA' => $vacuna,
                'MUERTE' => $muerte,
                'ID' => $id_mascota
            ];
            if(mascota_modelo::actualizar_mascota_modelo($datos_actualizar)){
                $alerta = [
                    'ALERTA' => 'recargar',
                    'ICONO' => 'success',
                    'TITULO' => 'Completado!',
                    'TEXTO' => 'Se han ACTUALIZADO los datos correctamente en el sistema'
                ];
            }else{
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'Hubo un ERROR al actulizar los datos en el sistema'
                ];
            }
            echo json_encode($alerta);
        } /* --- Fin de la funcion --- */
    }