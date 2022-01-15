<?php
    require_once './modelos/paginas_modelo.php';
    /* Creacion de clase para las paginas */
    class paginas_controlador extends paginas_modelo{
        /* --- Funcion controlador para obtener la plantilla base de la pagina --- */
        public function obtener_plantilla_controlador(){
            return require_once './paginas/plantilla.php';
        } /* --- Fin de la funcion --- */

        /* --- Funcion controlador para obtener la pagina correspondiente --- */
        public function obtener_paginas_controlador(){
            if(isset($_GET['veterinaria'])){
                $ruta = explode('/', $_GET['veterinaria']);
                $respuesta = paginas_modelo::obtener_paginas_modelo($ruta[0]);
            }else{
                $respuesta = 'index';
            }
            return $respuesta;
        }

    }