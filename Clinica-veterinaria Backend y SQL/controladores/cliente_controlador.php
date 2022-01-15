<?php
    /* Verificando si hay una peticion Ajax */
    if($peticion_ajax){
        require_once '../modelos/cliente_modelo.php';
    }else{
        require_once './modelos/cliente_modelo.php';
    }
    /* Clase controlador para los clientes, controlara */
    class cliente_controlador extends cliente_modelo{
        /* --- Funcion controlador para registrar un cliente --- */
        public function registrar_cliente_controlador(){
            $nombre = main_modelo::limpiar_cadena($_POST['cliente_nombre_reg']);
            $correo = main_modelo::limpiar_cadena($_POST['cliente_correo_reg']);
            $direccion = main_modelo::limpiar_cadena($_POST['cliente_direccion_reg']);
            $celular = main_modelo::limpiar_cadena($_POST['cliente_celular_reg']);
            $telefono = main_modelo::limpiar_cadena($_POST['cliente_telefono_reg']);

            /* Verificando que se registren todos los datos obligatorios ( al menos para mi) */
            if($nombre == '' || $correo == '' || $direccion == ''){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'No has llenado todos los datos obligatorios (NOMBRE - DIRECCION - EMAIL)'
                ];
                echo json_encode($alerta);
                exit();
            }
            /* Verificando los datos con los patterns correspondientes, evitando fallos si hay manipulacion en el HTML */
            if(main_modelo::verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}', $nombre)){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'El NOMBRE ingresado no corresponde con el formato solicitado'
                ];
                echo json_encode($alerta);
                exit();
            }if(main_modelo::verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,200}', $direccion)){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'La DIRECCION ingresado no corresponde con el formato solicitado'
                ];
                echo json_encode($alerta);
                exit();
            }if($celular != ''){
                if(main_modelo::verificar_datos('[0-9()+]{8,20}', $celular)){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'El TELEFONO MOVIL ingresado no corresponde con el formato solicitado'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }if($telefono != ''){
                if(main_modelo::verificar_datos('[0-9()+]{8,20}', $telefono)){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'El TELEFONO DE CASA ingresado no corresponde con el formato solicitado'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
                $check_correo = main_modelo::ejecutar_consulta_simple("SELECT cliente_correo FROM cliente WHERE cliente_correo = '$correo'");
                if($check_correo->rowCount() > 0){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'El CORREO ingresado ya existe en el sistema, ingrese otro correo diferente'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }else{
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'El CORREO ingresado no corresponde con el formato solicitado'
                ];
                echo json_encode($alerta);
                exit();
            }
            /* Fin de la verificacion de datos */

            /* Creando la estructura de datos que se registraran en la DB */
            $datos = [
                'NOMBRE' => $nombre,
                'DIRECCION' => $direccion,
                'CORREO' => $correo,
                'CELULAR' => $celular,
                'TELEFONO' => $telefono
            ];

            $registrar_cliente = cliente_modelo::registrar_cliente_modelo($datos);
            if($registrar_cliente->rowCount() == 1){
                $alerta = [
                    'ALERTA' => 'limpiar',
                    'ICONO' => 'success',
                    'TITULO' => 'DUEÑO REGISTRADO!',
                    'TEXTO' => 'El DUEÑO se ha registrado correctamente al sistema'
                ];
            }else{
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'Hubo un error al registrar el dueño al sistema'
                ];
            }
            echo json_encode($alerta);
        } /* --- Fin de la funcion --- */

        /* --- Funcion controlador para mostrar los clientes --- */
        public function lista_cliente_controlador($pagina_actual, $numero_registros, $url, $busqueda){
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE cliente_nombre LIKE '%$busqueda%' OR cliente_direccion LIKE '%$busqueda%' OR cliente_correo LIKE '%$busqueda%' OR cliente_celular LIKE '%$busqueda%' OR cliente_telefono LIKE '%$busqueda%' ORDER BY cliente_nombre ASC LIMIT $inicio, $numero_registros";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM cliente ORDER BY cliente_nombre ASC LIMIT $inicio, $numero_registros";
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
                            <th>Nº MASCOTAS</th>
                            <th>NOMBRE</th>
                            <th>CORREO ELECTRONICO</th>
                            <th>TELEFONO MOVIL</th>
                            <th>TELEFONO MOVIL</th>
                            <th>DIRECCIÓN</th>
                            <th>ACTUALIZAR</th>
                        </tr>
                    </thead>
                    <tbody class = "tabla-style">';
            
            if($datos_total > 0 && $pagina_actual <= $numero_paginas){
                $contador = $inicio + 1;
                /* Mostrandor los datos de la consulta anterior */
                foreach($datos as $dato){
                    /* Contando el numero de mascotas de cada cliente */
                    $propietario = $dato['cliente_nombre'];
                    $num_mascotas = main_modelo::ejecutar_consulta_simple("SELECT count(mascota_nombre) FROM mascota WHERE mascota_propietario = '$propietario'");
                    $num_mascotas = (int)$num_mascotas->fetchColumn();
                    /* tabla */
                    $tabla .= '<tr class="text-center">
                        <td>'.$contador.'</td>
                        <td>'.$num_mascotas.'</td>
                        <td>'.$dato['cliente_nombre'].'</td>
                        <td>'.$dato['cliente_correo'].'</td>
                        <td>'.$dato['cliente_celular'].'</td>
                        <td>'.$dato['cliente_telefono'].'</td>
                        <td>
                            <button type="button" class="btn btn-detalle" data-bs-toggle="popover" data-bs-trigger="hover" title="'.$dato['cliente_nombre'].'" data-bs-content="'.$dato['cliente_direccion'].'">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </td>
                        <td>
                            <a href="'.SERVERURL.'cliente-actualizar/'.main_modelo::cifrar($dato['cliente_id']).'" class="btn btn-actualizar">
                                    <i class="fas fa-sync-alt"></i>	
                            </a>
                        </td>
                    </tr>'
                    ;
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

        /* --- Funcion controlador para obtener los datos (pagina actualizar) --- */
        public function datos_cliente_controlador($id_cliente){
            $id_cliente = main_modelo::descifrar($id_cliente);
            $id_cliente = main_modelo::limpiar_cadena($id_cliente);

            return cliente_modelo::datos_cliente_modelo($id_cliente);
        } /* --- Fin de la funcion --- */

        /* --- Funcion controlador para actualizar un cliente --- */
        public function actualizar_cliente_controlador(){
            $id = main_modelo::descifrar($_POST['cliente_id_act']);
            $id = main_modelo::limpiar_cadena($id);
        
            /* Verificando que el cliente exista en el sistema */
            $check_cliente = main_modelo::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_id = '$id'");
            if($check_cliente->rowCount() <= 0){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'El DUEÑO que intentas actualizar no existe en el sistema'
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $datos_cliente = $check_cliente->fetch();
            }

            $nombre = main_modelo::limpiar_cadena($_POST['cliente_nombre_act']);
            $correo = main_modelo::limpiar_cadena($_POST['cliente_email_act']);
            $direccion = main_modelo::limpiar_cadena($_POST['cliente_direccion_act']);
            $celular = main_modelo::limpiar_cadena($_POST['cliente_celular_act']);
            $telefono = main_modelo::limpiar_cadena($_POST['cliente_telefono_act']);

            /* Verificando que se registren todos los datos obligatorios ( al menos para mi) */
            if($nombre == '' || $correo == '' || $direccion == ''){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'No has llenado todos los datos obligatorios (NOMBRE - DIRECCION - EMAIL)'
                ];
                echo json_encode($alerta);
                exit();
            }
            /* Verificando los datos con los patterns correspondientes, evitando fallos si hay manipulacion en el HTML */
            if($nombre != $datos_cliente['cliente_nombre']){
                $check_nombre = main_modelo::ejecutar_consulta_simple("SELECT cliente_nombre FROM cliente WHERE cliente_nombre = '$nombre'");
                if($check_nombre->rowCount() <= 0){
                    $cliente_anterio = $datos_cliente['cliente_nombre'];
                    $check_mascota = main_modelo::ejecutar_consulta_simple("SELECT mascota_nombre FROM mascota WHERE mascota_propietario = '$cliente_anterio' LIMIT 1");
                    if($check_mascota->rowCount() <= 0){
                        if(main_modelo::verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}', $nombre)){
                            $alerta = [
                                'ALERTA' => 'simple',
                                'ICONO' => 'error',
                                'TITULO' => 'Ha ocurrido un error!',
                                'TEXTO' => 'El NOMBRE ingresado no corresponde con el formato solicitado'
                            ];
                            echo json_encode($alerta);
                            exit();
                        }
                        $opcion = 'actualizar';
                    }else{
                        if(main_modelo::verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}', $nombre)){
                            $alerta = [
                                'ALERTA' => 'simple',
                                'ICONO' => 'error',
                                'TITULO' => 'Ha ocurrido un error!',
                                'TEXTO' => 'El NOMBRE ingresado no corresponde con el formato solicitado'
                            ];
                            echo json_encode($alerta);
                            exit();
                        }
                        $opcion = 'remplazar';
                    }
                }else{
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'El NOMBRE ingresado ya existe en el sistema'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }else{
                $opcion = 'actualizar';
            }if(main_modelo::verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,200}', $direccion)){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'La DIRECCION ingresado no corresponde con el formato solicitado'
                ];
                echo json_encode($alerta);
                exit();
            }if($celular != ''){
                if(main_modelo::verificar_datos('[0-9()+]{8,20}', $celular)){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'El TELEFONO MOVIL ingresado no corresponde con el formato solicitado'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }if($telefono != ''){
                if(main_modelo::verificar_datos('[0-9()+]{8,20}', $telefono)){
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'El TELEFONO DE CASA ingresado no corresponde con el formato solicitado'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }if($correo != $datos_cliente['cliente_correo']){
                if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
                    $check_correo = main_modelo::ejecutar_consulta_simple("SELECT cliente_correo FROM cliente WHERE cliente_correo = '$correo'");
                    if($check_correo->rowCount() > 0){
                        $alerta = [
                            'ALERTA' => 'simple',
                            'ICONO' => 'error',
                            'TITULO' => 'Ha ocurrido un error!',
                            'TEXTO' => 'El CORREO ingresado ya existe en el sistema, ingrese otro correo diferente'
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                }else{
                    $alerta = [
                        'ALERTA' => 'simple',
                        'ICONO' => 'error',
                        'TITULO' => 'Ha ocurrido un error!',
                        'TEXTO' => 'El CORREO ingresado no corresponde con el formato solicitado'
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
            /* Fin de la verificacion de datos */

            /* Creando la estructura de datos que se registraran en la DB */
            $datos = [
                'OPCION' => $opcion,
                'NOMBRE' => $nombre,
                'NOMBRE_ANT' => $datos_cliente['cliente_nombre'],
                'DIRECCION' => $direccion,
                'CORREO' => $correo,
                'CELULAR' => $celular,
                'TELEFONO' => $telefono,
                'ID' => $id
            ];

            // $registrado = cliente_modelo::actualizar_cliente_modelo($datos);
            if(cliente_modelo::actualizar_cliente_modelo($datos)){
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'success',
                    'TITULO' => 'Completado!',
                    'TEXTO' => 'Se han ACTUALIZADO los datos correctamente al sistema'
                ];
                echo json_encode($alerta); 
                
            }else{
                $alerta = [
                    'ALERTA' => 'simple',
                    'ICONO' => 'error',
                    'TITULO' => 'Ha ocurrido un error!',
                    'TEXTO' => 'Hubo un ERROR al actulizar los datos en el sistema'
                ];
                echo json_encode($alerta); 
                exit();
            }
        }
    }