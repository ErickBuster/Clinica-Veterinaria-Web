<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Archivos CSS -->
    <?php include './paginas/incluir/links_css.php'; ?>
    
    <title><?php echo PAGINA; ?></title>
</head>
<body>
    <!-- NavBar -->
    <?php include "./paginas/incluir/navbar.php"; ?>

    <!-- Contenido de la pagina -->
    <?php
        $peticion_ajax = False;
        require_once './controladores/paginas_controlador.php';
        $instancia_pagina = new paginas_controlador();
        $pagina = $instancia_pagina->obtener_paginas_controlador();
        session_start(['name' => 'clinica_veterinaria']);
        if($pagina == 'index'){
            require_once './paginas/paginas_veterinaria/index-veterinaria.php';
        }else{
            $pagina_array = explode('/', $_GET['veterinaria']);
            include $pagina;
        }
    ?>
    
    <!-- Pie Pagina -->
    <?php include './paginas/incluir/pie_pagina.php'; ?>

    <!-- Scripts JS -->
    <?php include './paginas/incluir/scripts_js.php'; ?>
</body>
</html>