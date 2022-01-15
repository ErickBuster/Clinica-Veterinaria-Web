<?php
    /* Aqui se ejecuta  toda la aplicacion */
    require_once './configuracion_servidor/aplicacion.php';
    require_once './controladores/paginas_controlador.php';

    $plantilla = new paginas_controlador();
    $plantilla->obtener_plantilla_controlador();