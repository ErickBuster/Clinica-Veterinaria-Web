<!-- Header -->
<div class="container pt-5">
    <div class="row-md">
        <div class="col-md ps-5">
            <h3 class = "text-justify"><i class="fas fa-sync"></i> &nbsp; ACTUALIZAR MASCOTA</h3>
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
            <a href="<?php echo SERVERURL; ?>mascota-buscar/" class = "seleccion text-shadow"><i class="fas fa-search"></i> &nbsp; BUSCAR MASCOTA</a>
        </div>
    </div>
</div>

<?php
        require_once './controladores/mascota_controlador.php';
        $instancia_mascota = new mascota_controlador();
        $datos_mascota = $instancia_mascota->datos_mascota_controlador($pagina_array[1]);

        if($datos_mascota->rowCount() == 1){
            $datos = $datos_mascota->fetch();
?>

<div class="container">
    <div class = "py-3 ps-5">
        <span class="roboto-medium">DUEÑO: &nbsp;&nbsp;<strong><?php echo $datos['mascota_propietario']; ?></strong>&nbsp;</span> 
        
    </div>
</div>

<!-- Content here-->
<div class="container">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL;?>Ajax/mascota_ajax.php" method = "POST" data-form = "actualizar" autocomplete="off">
    <input type="hidden" name = "mascota_id_act" value = "<?php echo main_modelo::cifrar($datos['mascota_id']); ?>">
        <fieldset>
            <legend class = "ps-3"><i class="fas fa-user"></i> &nbsp; Información básica</legend>
            <div class="container-fluid">
                <div class="row pt-3">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control input-style" id = "mascota_nombre" value = "<?php echo $datos['mascota_nombre']; ?>" disabled>
                            <label for="mascota_nombre">Nombre mascota</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control input-style" id="mascota_raza" value = "<?php echo $datos['mascota_raza']; ?>" disabled>
                            <label for="mascota_raza">Raza</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control input-style" id="mascota_sexo" value = "<?php echo $datos['mascota_sexo']; ?>" disabled>
                            <label for="mascota_sexo">Raza</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="mascota_fecha_nacimiento">Fecha de nacimiento</label>
                            <input type="date" class="form-control input-style py-2" id="mascota_fecha_nacimiento" value = "<?php echo $datos['mascota_nacimiento']; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="mascota_fecha_muerte">Fecha de muerte (actualizable)</label>
                            <input type="date" class="form-control input-style py-2" name="mascota_fecha_muerte_act" id="mascota_fecha_muerte" value = "<?php echo $datos['mascota_muerte']; ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating mb-3 mt-2">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,150}" class="form-control input-style" name="mascota_vacuna_act" id="mascota_vacuna" placeholder="raza mascota" maxlength="200" value = "<?php echo $datos['mascota_vacuna']; ?>">
                            <label for="mascota_vacuna">Vacunas (actualizable)</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center mt-5">
            <button type="reset" class="btn btn-secondary btn-auto btn-hov"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-auto btn-guardar"><i class="far fa-save"></i> &nbsp; ACTUALIZAR</button>
        </p>
    </form>
    <?php }else{ ?>

<div class="alert alert-danger text-center" role="alert">
    <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
    <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
    <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
</div>
<?php } ?>