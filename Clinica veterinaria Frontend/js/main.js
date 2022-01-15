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

var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})