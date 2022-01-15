/* -----------------------------
    Variables para deslizamiento 
    ----------------------------- */
window.sr = ScrollReveal()
    sr.reveal('.navbar', {
        duration: 2000,
        origin: 'bottom'
})
window.sr = ScrollReveal()
    sr.reveal('.header-head', {
        duration: 5000,
        origin: 'bottom'
})
window.sr = ScrollReveal()
    sr.reveal('.header-left', {
        duration: 2000,
        origin: 'left',
        distance: '500px',
        viewFactor: 0.2
})
window.sr = ScrollReveal()
    sr.reveal('.header-right', {
        duration: 2000,
        origin: 'right',
        distance: '500px',
        viewFactor: 0.2
})
window.sr = ScrollReveal()
    sr.reveal('.header-top', {
        duration: 2000,
        origin: 'top',
        distance: '500px',
        viewFactor: 0.2
})
window.sr = ScrollReveal()
    sr.reveal('.header-buttom', {
        duration: 2000,
        origin: 'bottom',
        distance: '500px',
        viewFactor: 0.2
})

/* -----------------------------
    Variables para ventana dueños 
    ----------------------------- */
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})

/* -----------------------------
    Alertas para los formularios Ajax 
    ----------------------------- */
const formulario_ajax = document.querySelectorAll('.FormularioAjax') // Funcion para seleccionar todos los elementos para un selector (fomularios)

/* --- Fuincion para enviar el formulario  --- */
function enviar_formulario_ajax(evento){
    evento.preventDefault(); // prevenir el evento de redireccionamiento - ya no redirecciona a la siguiente pagina

    let datos = new FormData(this)
    let metodo = this.getAttribute('method')
    let accion = this.getAttribute('action')
    let tipo = this.getAttribute('data-form')

    let encabezados = new Headers()

    let configuracion_json = {
        method: metodo,
        headers: encabezados,
        mode: 'cors',
        cache: 'no-cache',
        body: datos
    }

    /* tipo de form-data para el mensaje */
    let texto_alerta
    if(tipo === 'guardar'){
        texto_alerta = 'Los datos quedaran guardados en el sistema'
    }else if(tipo === 'eliminar'){
        texto_alerta = 'Los datos seran eliminados del sistema'
    }else if(tipo === 'actualizar'){
        texto_alerta = 'Los datos seran actualizados en el sistema'
    }else if(tipo === 'buscar'){
        texto_alerta = 'Se eliminara la busqueda guardada anterior, y tendras que realizar otra busqueda'
    }else if(tipo === 'quitar'){
        texto_alerta = 'Desea remover los datos seleccionados?'
    }else{
        texto_alerta = 'Quieres realizar la operacion solicitada?'
    }

    Swal.fire(
        'The Internet?',
        'That thing is still around?',
        'question'
    )

    /* mostrando mensaje */ 
    Swal.fire({
        title: 'Estas seguro?',
        text: texto_alerta,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed){
            fetch(accion, configuracion_json)
            .then(respuesta => respuesta.json())
            .then(respuesta => {
                return alertas_ajax(respuesta)
            })
        }
    })
    
}

formulario_ajax.forEach(formularios => {
    formularios.addEventListener('submit', enviar_formulario_ajax)
})

/* --- Funcion para crear alertas ajax el momento de enviar datos --- */
function alertas_ajax(alerta){
    /* Creacion de tipos de alertas */
    if(alerta.ALERTA === 'simple'){
        Swal.fire({
            icon: alerta.ICONO,
            title: alerta.TITULO,
            text: alerta.TEXTO,
            confirmButtonText: 'Aceptar!'
        })
    }else if(alerta.ALERTA === 'recargar'){
        Swal.fire({
            icon: alerta.ICONO,
            title: alerta.TITULO,
            text: alerta.TEXTO,
            confirmButtonText: 'Aceptar!'
        }).then((result) => {
            if (result.isConfirmed){
                location.reload()
            }
        })
    }else if(alerta.ALERTA === 'limpiar'){
        Swal.fire({
            icon: alerta.ICONO,
            title: alerta.TITULO,
            text: alerta.TEXTO,
            confirmButtonText: 'Aceptar!'
        }).then((result) => {
            if (result.isConfirmed){
                document.querySelector('.FormularioAjax').reset()
            }
        })
    }else if(alerta.ALERTA === 'redireccionar'){
            window.location.href = alerta.URL
    }
}/* --- Fin de la funcion --- */

