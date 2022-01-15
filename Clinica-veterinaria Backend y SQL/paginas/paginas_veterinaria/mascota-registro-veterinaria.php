<!-- Header -->
<div class="container pt-5">
    <div class="row-md">
        <div class="col-md ps-5">
            <h3 class = "text-justify"><i class="fas fa-plus-circle"></i> &nbsp; AGREGAR MASCOTA</h3>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Harum tempore quidem porro deserunt dolorem aspernatur eveniet, aliquid impedit atque, eum soluta modi libero veritatis voluptas excepturi hic veniam qui amet!</p>
        </div>
    </div>
</div>

<!-- Menu -->
<div class="container">
    <div class="row p-5">
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-end">
            <a href="<?php echo SERVERURL; ?>mascota-registro/" class = "active deshabilidato text-shadow"><i class="fas fa-plus"></i> &nbsp; AGREGAR MASCOTA</a>
        </div>
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-center">
            <a href="<?php echo SERVERURL; ?>mascota-lista/" class = "seleccion text-shadow"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE MASCOTAS</a>
        </div>
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-start">
            <a href="<?php echo SERVERURL; ?>mascota-buscar/" class = "seleccion text-shadow"><i class="fas fa-search"></i> &nbsp; BUSCAR MASCOTA</a>
        </div>
    </div>
</div>

<!--Agregar Dueño -->
<!-- Button trigger modal -->
<div class="container">
    <div class="row">
        <div class="col-12 d-flex justify-content-center pb-3">
            <?php if(empty($_SESSION['datos_cliente'])){ ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fas fa-user-plus"></i> &nbsp; Agregar Dueño
                </button>
             <?php } ?>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Agregar Dueño</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-floating mb-3">
                <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control input-style" name="cliente_nombre_buscar" id="cliente_nombre" placeholder="Nombre dueño"  maxlength="50" required>
                <label for="cliente_nombre">Nombre del dueño</label>
            </div>
            <div class="container-fluid tabla-style" id="tabla_clientes">
                <!--
                 Resultado de la busqueda 
                                        -->
            </div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-hov" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-hov" onclick = "buscar_propietario()"><i class="fas fa-search"></i> Buscar</button>
            </div>
        </div>
    </div>
</div>

<!-- Agregando el propietario -->
<div class="container">
    <div class = "py-3 ps-5">
        <span class="roboto-medium">DUEÑO:</span> 
        <?php if(empty($_SESSION['datos_cliente'])){ ?>
            <span class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i><strong>  Seleccione un dueño para la mascota </strong></span>
        <?php }else{ ?>
            <form class="form-neon FormularioAjax" action = "<?php echo SERVERURL;?>Ajax/mascota_ajax.php" method = "POST" data-form = "quitar" style="display: inline-block !important;" autocomplete="off">
                <input type = "hidden" name = "eliminar_cliente_id" value = "<?php echo $_SESSION['datos_cliente']['ID']?>">
                &nbsp;&nbsp;<strong><?php echo $_SESSION['datos_cliente']['NOMBRE'].' ('.$_SESSION['datos_cliente']['CORREO'].') '; ?></strong>&nbsp;
                <button type="submit" class="btn btn-sm btn-eliminar-cliente"><i class="fas fa-user-times"></i></button>
            </form>
        <?php } ?>
    </div>
</div>

<!-- Content here-->
<div class="container">
    <form class="form-neon FormularioAjax" action="<?php echo SERVERURL;?>Ajax/mascota_ajax.php" method = "POST" data-form = "guardar" autocomplete="off">
        <fieldset>
            <legend class = "ps-3"><i class="fas fa-user"></i> &nbsp; Información básica</legend>
            <div class="container-fluid">
                <div class="row pt-3">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control input-style" name="mascota_nombre_reg" id="mascota_nombre" placeholder="Nombre mascota"  maxlength="50" required>
                            <label for="mascota_nombre">Nombre mascota</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control input-style" name="mascota_raza_reg" id="mascota_raza" placeholder="raza mascota" maxlength="50" required>
                            <label for="mascota_raza">Raza</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group mb-3">
                            <span>Sexo mascota &nbsp; <span class="badge badge-info"></span></span>
                            <select class="form-control input-style py-2" name="mascota_sexo_reg" required>
                                <option value="" selected="" disabled="">Seleccione una opción</option>
                                <option value="Macho">Macho</option>
                                <option value="Hembra">Hembra</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="mascota_fecha_nacimiento">Fecha de nacimiento</label>
                            <input type="date" class="form-control input-style py-2" name="mascota_fecha_nacimiento_reg" id="mascota_fecha_nacimiento">
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="mascota_fecha_muerte">Fecha de muerte</label>
                            <input type="date" class="form-control input-style py-2" name="mascota_fecha_muerte_reg" id="mascota_fecha_muerte">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating mb-3 mt-2">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,200}" class="form-control input-style" name="mascota_vacuna_reg" id="mascota_vacuna" placeholder="raza mascota" maxlength="200" required>
                            <label for="mascota_vacuna">Vacunas</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <p class="text-center mt-5">
            <button type="reset" class="btn btn-secondary btn-auto btn-hov"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-auto btn-guardar"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
    </form>
</div>