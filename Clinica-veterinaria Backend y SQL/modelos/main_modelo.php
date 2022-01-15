<?php
    /* Verificando si hay una peticion Ajax */
    if($peticion_ajax){
        require_once '../configuracion_servidor/servidor.php';
    }else{
        require_once './configuracion_servidor/servidor.php';
    }
    /* Modelo principal quien se encargar con la coneccion a la base de datos */
    class main_modelo{
        /* --- Funcion modelo para la coneccion a la base de datos --- */
        protected static function coneccion_db(){
            $coneccion_DB = new PDO(CONECCION, USUARIO, PASS);
            $coneccion_DB->exec("SET CHARACTER SET utf8");
            return $coneccion_DB;
        } /* --- Fin de la funcion --- */

        /* --- Funcion modelo para ejecutar consultas simple --- */
        protected static function ejecutar_consulta_simple($consulta){
            $sql = self::coneccion_db()->prepare($consulta);
            $sql->execute();
            return $sql;
        } /* --- Funcion modelo --- */

        /* --- Funcion para cifrar texto, claves, id, etc --- */
        public static function cifrar($string){
            $salida = False;
            $key = hash('sha256', SECRET_KEY) ;
            $iv = substr(hash('sha256', SECRET_IV), 0, 16);
            $salida = openssl_encrypt($string, METODO, $key, 0, $iv);
            $salida = base64_encode($salida);
            return $salida;
        }/* --- Fin de la funcion --- */

        /* --- Funcion para descifrar texto, claves, id, etc --- */
        public static function descifrar($string){
            $key = hash('sha256', SECRET_KEY);
            $iv = substr(hash('sha256', SECRET_IV), 0, 16);
            $salida = openssl_decrypt(base64_decode($string), METODO, $key, 0, $iv);
            return $salida;
        }/* --- Fin de la funcion --- */

        /* --- Funcion modelo para limpiar cadenas de formularios (Evitar SQLinjection, XSS)--- */
        protected static function limpiar_cadena($cadena){
            $cadena = trim($cadena); // quita los espacio que esten andes o despues del texto
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
        } /* --- Fin de la funcion --- */

        /* --- Funcion modelo para verificar los datos enviados --- */
        protected static function verificar_datos($expresion_regular, $cadena){
            if(preg_match('/^'.$expresion_regular.'$/', $cadena)){
                return False;
            }else{
                return True;
            }
        } /* --- Fin de la funcion --- */

        /* --- Funcion modelo para verificar las fechas --- */
        protected static function verificar_fechas($fecha){
            $valores = explode('-',$fecha);
            if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
                return False;
            }else{
                return True;
            }
        } /* --- Fin de la funcion --- */

        /* --- Funcion modelo para paginar las tablas (botoneria)--- */
        protected static function paginar_tablas($pagina_actual, $numero_paginas, $url, $numero_botones){
            $tabla = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">'; // etiqueta de apertura
            /* botonera inicial */
            if($pagina_actual == 1){
                $tabla .= '<li class="page-item px-1 disabled"><a class="page-link rounded-circle"><i class="fas fa-angle-double-left"></i></a></li>';
            }else{
                $tabla .= '<li class="page-item px-1">
                    <a class="page-link rounded-circle" href = "'.$url.'1/"><i class="fas fa-angle-double-left"></i></a>
                    </li>
                    <li class="page-item px-1">
                        <a class="page-link rounded-circle" href = "'.$url.($pagina_actual - 1).'">Anterior</a>
                    </li>';
            }
            /* botones centrales */
            $contador = 0;
            for($i = $pagina_actual; $i <= $numero_paginas; $i++){
                if($contador >= $numero_botones){
                    break;
                }if($pagina_actual == $i){
                    $tabla .= '<li class="page-item px-1"><a class="page-link rounded-circle active" style = "background-color: #FFC269" href="'.$url.$i.'/">'.$i.'</a></li>';
                }else{
                    $tabla .= '<li class="page-item px-1"><a class="page-link rounded-circle" href="'.$url.$i.'/">'.$i.'</a></li>';
                }
                $contador++;
            }

            /* botonera final */
            if($pagina_actual == $numero_paginas){
                $tabla .= '<li class="page-item px-1 disabled"><a class="page-link rounded-circle"><i class="fas fa-angle-double-right"></i></a></li>';
            }else{
                $tabla .= '<li class="page-item px-1">
                        <a class="page-link rounded-circle" href = "'.$url.($pagina_actual + 1).'">Siguiente</a>
                    </li>
                    <li class="page-item px-1">
                        <a class="page-link rounded-circle" href = "'.$url.$numero_paginas.'/"><i class="fas fa-angle-double-right"></i></a>
                    </li>';
            }
            $tabla .= '</ul></nav>'; //etiqueta de cierre
            return $tabla;
        }
    }   