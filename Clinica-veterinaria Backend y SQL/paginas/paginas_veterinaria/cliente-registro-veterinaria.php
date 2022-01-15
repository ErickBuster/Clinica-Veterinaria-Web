<!-- Header -->
<div class="container pt-5">
    <div class="row-md">
        <div class="col-md ps-5">
            <h3 class = "text-justify"><i class="fas fa-plus-circle"></i> &nbsp; AGREGAR DUEÑO</h3>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Harum tempore quidem porro deserunt dolorem aspernatur eveniet, aliquid impedit atque, eum soluta modi libero veritatis voluptas excepturi hic veniam qui amet!</p>
        </div>
    </div>
</div>

<!-- Menu -->
<div class="container">
    <div class="row p-5">
        <div class="col-12 col-md-4 text-center d-flex justify-content-md-end">
            <a href="<?php echo SERVERURL; ?>cliente-registro/" class = "active deshabilidato text-shadow"><i class="fas fa-plus"></i> &nbsp; AGREGAR DUEÑO</a>
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
    <form class="form-neon FormularioAjax" action = "<?php echo SERVERURL;?>Ajax/cliente_ajax.php" method = "POST" data-form = "guardar" autocomplete="off">
        <fieldset>
            <legend class = "ps-3"><i class="fas fa-user"></i> &nbsp; Información básica</legend>
            <div class="container-fluid">
                <div class="row pt-3">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control input-style" name="cliente_nombre_reg" id="cliente_nombre" placeholder="Nombre"  maxlength="50" >
                            <label for="cliente_nombre">Nombre completo</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,200}" class="form-control  input-style" name="cliente_direccion_reg" id="cliente_direccion" placeholder="direccion" maxlength="200" >
                            <label for="cliente_direccion">Dirección</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control input-style" name="cliente_correo_reg" id="cliente_correo" placeholder = "correo electronico" maxlength="70" >
                            <label for="cliente_correo">Correo electronico</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control input-style" name="cliente_celular_reg" id="cliente_celular" placeholder="celular" maxlength="20" >
                            <label for="cliente_celular">Telefono movil</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="[0-9()+]{8,20}" class="form-control input-style" name="cliente_telefono_reg" id="cliente_telefono" placeholder="telefono" maxlength="20" >
                            <label for="cliente_telefono">Teléfono Casa</label>
                        </div>
                    </div>
                    
                </div>
            </div>
        </fieldset>
        <p class="text-center" style="margin-top: 40px;">
            <button type="reset" class="btn btn-secondary btn-auto btn-hov"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
            &nbsp; &nbsp;
            <button type="submit" class="btn btn-raised btn-auto btn-guardar"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
        </p>
    </form>
</div>