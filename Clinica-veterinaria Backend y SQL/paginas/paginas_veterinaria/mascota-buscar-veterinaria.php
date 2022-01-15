<!-- Header -->
<div class="container pt-5">
    <div class="row-md">
        <div class="col-md ps-5">
            <h3 class = "text-justify"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; BUSCAR MASCOTA</h3>
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
            <a href="<?php echo SERVERURL; ?>mascota-lista/" class = "seleccion text-shadow"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE MASCOTAS</a>
        </div>
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-start">
            <a href="<?php echo SERVERURL; ?>mascota-buscar/" class = "active deshabilidato text-shadow"><i class="fas fa-search"></i> &nbsp; BUSCAR MASCOTA</a>
        </div>
    </div>
</div>


<?php 
    if(!isset($_SESSION['busqueda_mascota']) && empty($_SESSION['busqueda_mascota'])){
?>

<!-- Busqueda mascota -->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action = "<?php echo SERVERURL; ?>Ajax/buscador_ajax.php" method = "POST" data-form = "default" autocomplete="off">
        <input type = "hidden" name = "modulo" value = "mascota">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control text-center input-style" name="busqueda_inicial" id="mascota_buscar" placeholder = "buscar_mascota" maxlength="30">
                        <label for="mascota_buscar">¿Qué mascota estas buscando?</label>
                        <p>Mostrar informacion/vacunas de la mascota, buscando a traves del nombre, propietario o correo electronico</p>
                    </div>
                </div>
                <div class="col-12">
                    <p class="text-center" style="margin-top: 40px;">
                        <button type="submit" class="btn btn-raised btn-auto btn-buscar"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<?php }else{ ?>
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action = "<?php echo SERVERURL; ?>Ajax/buscador_ajax.php" method = "POST" data-form = "buscar" autocomplete="off">
        <input type = "hidden" name = "modulo" value = "mascota">
        <input type="hidden" name="eliminar_busqueda" value="eliminar">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                    Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_mascota']; ?>”</strong>
                    </p>
                </div>
                <div class="col-12">
                    <p class="text-center pb-3" style="margin-top: 20px;">
                        <button type="submit" class="btn btn-raised btn-danger btn-eliminar"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
                    </p>
                </div>
            </div>
        </div>
    </form>
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
        echo $instancia_mascota->lista_mascota_controlador($pagina_array[1], $numero_registros_por_pagina, $pagina_array[0], $_SESSION['busqueda_mascota']);
    ?>
</div>
<?php } ?>