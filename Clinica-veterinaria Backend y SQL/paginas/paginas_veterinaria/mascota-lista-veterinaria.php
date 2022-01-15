<!-- Header -->
<div class="container pt-5">
    <div class="row-md">
        <div class="col-md ps-5">
            <h3 class = "text-justify"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA MASCOTAS</h3>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Harum tempore quidem porro deserunt dolorem aspernatur eveniet, aliquid impedit atque, eum soluta modi libero veritatis voluptas excepturi hic veniam qui amet!</p>
        </div>
    </div>
</div>

<!-- Menu -->
<div class="container">
    <div class="row p-5">
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-end">
            <a href="<?php echo SERVERURL; ?>mascota-registro/" class = "seleccion text-shadow"><i class="fas fa-plus"></i> &nbsp; AGREGAR MASCOTA</a>
        </div>
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-center">
            <a href="<?php echo SERVERURL; ?>mascota-lista/" class = "active deshabilidato text-shadow"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE MASCOTAS</a>
        </div>
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-start">
            <a href="<?php echo SERVERURL; ?>mascota-buscar/" class = "seleccion text-shadow"><i class="fas fa-search"></i> &nbsp; BUSCAR MASCOTA</a>
        </div>
    </div>
</div>

<!-- Content here-->
<div class="container">
    <?php 
        require_once './controladores/mascota_controlador.php';
        $instancia_mascota = new mascota_controlador();
        $numero_registros_por_pagina = 5;
        if(!isset($pagina_array[1])){
            $pagina_array[1] = 0;
        }
        echo $instancia_mascota->lista_mascota_controlador($pagina_array[1], $numero_registros_por_pagina, $pagina_array[0], '');
    ?>
</div>