<!-- Bootstrap 5 JS -->
<script src = "<?php echo SERVERURL;?>paginas/js/popper.min.js"> </script>
<script src = "<?php echo SERVERURL;?>paginas/js/bootstrap.min.js"> </script>
<script src = "<?php echo SERVERURL;?>paginas/js/jquery-3.4.1.min.js"> </script>
<script src = "<?php echo SERVERURL;?>paginas/js/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- Scrollreveal -->
<script src="https://unpkg.com/scrollreveal"></script>
<!-- Sweet Alerts -->
<script src = "<?php echo SERVERURL;?>paginas/js/sweetalert2.min.js"> </script>
<!-- main JS -->
<script src = "<?php echo SERVERURL;?>paginas/js/main.js"> </script>

<script>
/* -----------------------------
    Funcion para la busqueda de dueños en la pagina mascota-registro 
    ----------------------------- */
function buscar_propietario(){
    let busqueda_propietario = document.querySelector('#cliente_nombre').value
    busqueda_propietario.trim()
    if(busqueda_propietario != ''){
        let datos = new FormData()
        datos.append("buscar_cliente",busqueda_propietario)
            fetch("<?php echo SERVERURL?>Ajax/mascota_ajax.php", {
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.text())
            .then(respuesta => {
                let tabla_propietarios = document.querySelector('#tabla_clientes')
                tabla_propietarios.innerHTML = respuesta
            })
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Ha ocurrido un error!',
            text: 'El campo de BUSQUEDA esta vacio, favor de introducir un (NOMBRE, CORREO, TELEFONO)',
            confirmButtonText: 'Aceptar!'
        })
    }
}
</script>

<script>
/* -----------------------------
    Funcion para agregar dueños en la pagina mascota-registro 
    ----------------------------- */
function agregar_cliente_mascota(id_cliente){
    $('#staticBackdrop').modal('hide')

    /* mostrando mensaje */ 
    Swal.fire({
        title: 'Quieres agregar este dueño?',
        text: 'Se va agregar como dueño para el registro de la mascota',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Agregar dueño!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed){
            let datos = new FormData()
            datos.append("agregar_cliente_id",id_cliente)
            fetch("<?php echo SERVERURL?>Ajax/mascota_ajax.php", {
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.json())
            .then(respuesta => {
                return alertas_ajax(respuesta)
            })
        }else{
            $('#staticBackdrop').modal('show')
        }
    })
}
</script>