<!-- Header -->
<div class="container pt-5">
    <div class="row-md">
        <div class="col-md ps-5">
            <h3 class = "text-justify"><i class="fas fa-sync"></i> &nbsp; ACTUALIZAR DUEÑO</h3>
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
            <a href="<?php echo SERVERURL; ?>cliente-buscar/" class = "seleccion text-shadow"><i class="fas fa-search"></i> &nbsp; BUSCAR DUEÑO</a>
        </div>
    </div>
</div>

<!-- Content here-->
<div class="container">
    <?php
        require_once './controladores/cliente_controlador.php';
        $instancia_cliente = new cliente_controlador();
        $datos_cliente = $instancia_cliente->datos_cliente_controlador($pagina_array[1]);

        if($datos_cliente->rowCount() == 1){
            $datos = $datos_cliente->fetch();
    ?>
    <form class="form-neon FormularioAjax" action = "<?php echo SERVERURL; ?>Ajax/cliente_ajax.php" method = "POST" data-form = "actualizar" autocomplete="off">
        <input type = "hidden" name = "cliente_id_act" value = <?php echo $pagina_array[1]; ?> >
        <fieldset>
            <legend class = "ps-3"><i class="fas fa-user"></i> &nbsp; Información básica</legend>
            <div class="container-fluid">
                <div class="row pt-3">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control input-style" name="cliente_nombre_act" id="cliente_nombre" placeholder="Nombre"  maxlength="50" value = "<?php echo $datos['cliente_nombre'];?>" required>
                            <label for="cliente_nombre">Nombre completo</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,200}" class="form-control  input-style" name="cliente_direccion_act" id="cliente_direccion" placeholder="direccion" maxlength="200" value = "<?php echo $datos['cliente_direccion'];?>" required>
                            <label for="cliente_direccion">Dirección</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control input-style" name="cliente_email_act" id="cliente_email" placeholder = "correo electronico" maxlength="50" value = "<?php echo $datos['cliente_correo'];?>" required>
                            <label for="cliente_email">Correo electronico</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control input-style" name="cliente_celular_act" id="cliente_celular" placeholder="celular" maxlength="20" value = "<?php echo $datos['cliente_celular'];?>">
                            <label for="cliente_celular">Telefono movil</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control input-style" name="cliente_telefono_act" id="cliente_telefono" placeholder="telefono" maxlength="20" value = "<?php echo $datos['cliente_telefono'];?>">
                            <label for="cliente_telefono">Teléfono Casa</label>
                        </div>
                    </div>
                    
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-secondary btn-auto btn-hov"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-auto btn-guardar"><i class="far fa-save"></i> &nbsp; ACTUALIZAR</button>
        </p>
    </form>
    
    <?php }else{ ?>

    <div class="alert alert-danger text-center" role="alert">
        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
        <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
    </div>
    <?php } ?>
</div>