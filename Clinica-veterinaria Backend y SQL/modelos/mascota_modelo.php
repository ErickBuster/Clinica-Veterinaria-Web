<?php
    require_once 'main_modelo.php';

    /* Clase modelo para las peticiones a la base de datos */
    class mascota_modelo extends main_modelo{
        /* --- Funcion modelo para registrar una mascota --- */ 
        protected static function agregar_mascota_modelo($datos){
            $sql = main_modelo::coneccion_db()->prepare("INSERT INTO mascota(mascota_nombre, mascota_propietario, mascota_raza, mascota_sexo, mascota_nacimiento, mascota_muerte, mascota_vacuna) VALUES(:NOMBRE, :PROPIETARIO, :RAZA, :SEXO, :NACIMIENTO, :MUERTE, :VACUNA)");
            $sql->bindParam(':NOMBRE', $datos['NOMBRE']);
            $sql->bindParam(':PROPIETARIO', $datos['PROPIETARIO']);
            $sql->bindParam(':RAZA', $datos['RAZA']);
            $sql->bindParam(':SEXO', $datos['SEXO']);
            $sql->bindParam(':NACIMIENTO', $datos['NACIMIENTO']);
            $sql->bindParam(':MUERTE', $datos['MUERTE']);
            $sql->bindParam(':VACUNA', $datos['VACUNA']);

            $sql->execute();
            return $sql;
        } /* --- Fin de la funcion --- */

        /* --- Funcion modelo para obtener los datos de la mascota --- */
        protected static function datos_mascota_modelo($id_mascota){
            $sql = main_modelo::coneccion_db()->prepare("SELECT * FROM mascota WHERE mascota_id = :ID");
            $sql->bindParam(':ID', $id_mascota);
            $sql->execute();
            return $sql;
        } /* --- Fin de la funcion --- */ 

        protected static function actualizar_mascota_modelo($datos){
            $sql = main_modelo::coneccion_db()->prepare("UPDATE mascota SET mascota_muerte = :MUERTE, mascota_vacuna = :VACUNA WHERE mascota_id = :ID");
            $sql->bindParam(':MUERTE',$datos['MUERTE']);
            $sql->bindParam(':VACUNA',$datos['VACUNA']);
            $sql->bindParam(':ID',$datos['ID']);

            $sql->execute();
            return $sql;
        }
    }