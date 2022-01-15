<!-- Header -->
<div class="container pt-5">
    <div class="row-md">
        <div class="col-md ps-5">
            <h3 class = "text-justify"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; BUSCAR DUEÑOS</h3>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Harum tempore quidem porro deserunt dolorem aspernatur eveniet, aliquid impedit atque, eum soluta modi libero veritatis voluptas excepturi hic veniam qui amet!</p>
        </div>
    </div>
</div>

<!-- Menu -->
<div class="container">
    <div class="row p-5">
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-end">
            <a href="<?php echo SERVERURL; ?>cliente-registro/" class = "seleccion text-shadow"><i class="fas fa-plus"></i> &nbsp; AGREGAR DUEÑO</a>
        </div>
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-center">
            <a href="<?php echo SERVERURL; ?>cliente-lista/" class = "seleccion text-shadow"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DUEÑOS</a>
        </div>
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-start">
            <a href="<?php echo SERVERURL; ?>cliente-buscar/" class = "active deshabilidato text-shadow"><i class="fas fa-search"></i> &nbsp; BUSCAR DUEÑO</a>
        </div>
    </div>
</div>

<?php 
    if(!isset($_SESSION['busqueda_cliente']) && empty($_SESSION['busqueda_cliente'])){
?>
<!-- Busqueda Cliente -->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action = "<?php echo SERVERURL; ?>Ajax/buscador_ajax.php" method = "POST" data-form = "default" autocomplete="off">
        <input type = "hidden" name = "modulo" value = "cliente">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control text-center input-style" name="busqueda_inicial" id="cliente_buscar" placeholder = "buscar_cliente" maxlength="30">
                        <label for="cliente_buscar">¿Qué dueño estas buscando?</label>
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
        <input type = "hidden" name = "modulo" value = "cliente">
        <input type="hidden" name="eliminar_busqueda" value="eliminar">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <p class="text-center" style="font-size: 20px;">
                        Resultados de la busqueda <strong>“<?php echo $_SESSION['busqueda_cliente']; ?>”</strong>
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
        require_once './controladores/cliente_controlador.php';
        $instancia_cliente = new cliente_controlador();
        $numero_registros_por_pagina = 5;
        if(!isset($pagina_array[1])){
            $pagina_array[1] = 0;
        }
        echo $instancia_cliente->lista_cliente_controlador($pagina_array[1], $numero_registros_por_pagina, $pagina_array[0], $_SESSION['busqueda_cliente']);
    ?>
</div>
<?php } ?>