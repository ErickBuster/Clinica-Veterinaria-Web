<?php 
    /* Creacion de modelo para las paginas */
    class paginas_modelo{
        /* --- Funcion modelo para obtener las paginas --- */
        protected static function obtener_paginas_modelo($pagina){
            $lista_blanca = ['cliente-actualizar', 'cliente-buscar', 'cliente-lista', 'cliente-registro', 'mascota-actualizar', 'mascota-buscar', 'mascota-lista', 'mascota-registro'];
            if(in_array($pagina, $lista_blanca)){
                if(is_file('./paginas/paginas_veterinaria/'.$pagina.'-veterinaria.php')){
                    $contenido  = './paginas/paginas_veterinaria/'.$pagina.'-veterinaria.php';
                }else{
                    $contenido = 'index';
                }
            }elseif($pagina == 'index'){
                $contenido = 'index';
            }else{
                $contenido = 'index';
            }
            return $contenido;
        } /* --- Fin de la funcion --- */
    }