<?php
    require_once 'main_modelo.php';

    /* Clase modelo para los clientes, se encargara de hacer las peticiones a la base de datos */
    class cliente_modelo extends main_modelo{
        /* --- Funcion modelo para registrar un cliente --- */
        protected static function registrar_cliente_modelo($datos){
            $sql = main_modelo::coneccion_db()->prepare("INSERT INTO cliente(cliente_nombre, cliente_direccion, cliente_correo, cliente_celular, cliente_telefono) VALUES(:NOMBRE, :DIRECCION, :CORREO, :CELULAR, :TELEFONO)");
            $sql->bindParam(':NOMBRE', $datos['NOMBRE']);
            $sql->bindParam(':DIRECCION', $datos['DIRECCION']);
            $sql->bindParam(':CORREO', $datos['CORREO']);
            $sql->bindParam(':CELULAR', $datos['CELULAR']);
            $sql->bindParam(':TELEFONO', $datos['TELEFONO']);

            $sql->execute();
            return $sql;
        } /* --- Fin de la funcion --- */

        /* --- Funcion para obtener los datos del cliente --- */
        protected static function datos_cliente_modelo($id_cliente){
            $sql = main_modelo::coneccion_db()->prepare("SELECT * FROM cliente WHERE cliente_id = :ID");
            $sql->bindParam(':ID', $id_cliente);
            $sql->execute();
            return $sql;
        }

        /* --- Funcion modelo para actualizawr un cliente --- */
        protected static function actualizar_cliente_modelo($datos){
            if($datos['OPCION'] == 'actualizar'){
                $sql = main_modelo::coneccion_db()->prepare("UPDATE cliente SET cliente_nombre = :NOMBRE, cliente_direccion = :DIRECCION, cliente_correo = :CORREO, cliente_celular = :CELULAR, cliente_telefono = :TELEFONO WHERE cliente_id = :ID");
            }elseif($datos['OPCION'] == 'remplazar'){
                $sql = main_modelo::coneccion_db()->prepare("INSERT INTO cliente(cliente_nombre, cliente_direccion, cliente_correo, cliente_celular, cliente_telefono) VALUES(:NOMBRE, :DIRECCION, :CORREO, :CELULAR, :TELEFONO); UPDATE mascota SET mascota_propietario = :NOMBRE WHERE mascota_propietario = :NOMBRE_ANT; DELETE FROM cliente WHERE cliente_id = :ID");
                $sql->bindParam(':NOMBRE_ANT', $datos['NOMBRE_ANT']);
            }
            $sql->bindParam(':ID', $datos['ID']);
            $sql->bindParam(':NOMBRE', $datos['NOMBRE']);
            $sql->bindParam(':DIRECCION', $datos['DIRECCION']);
            $sql->bindParam(':CORREO', $datos['CORREO']);
            $sql->bindParam(':CELULAR', $datos['CELULAR']);
            $sql->bindParam(':TELEFONO', $datos['TELEFONO']);

            $sql->execute();
            return $sql;
        } /* --- Fin de la funcion --- */
    }