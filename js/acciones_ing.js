/* Mostrar ventana modal para evitar eliminar ingredientes por error */
/* Elementos del formulario */
const form = document.getElementById('formulario');
const subDel = document.getElementById('eliminar');
const accIpt = document.getElementById('accion');

/* Elementos de la ventana modal */
const modal = document.getElementById('modalDel');
const btnDel = document.getElementById('btnDel');
const btnCan = document.getElementById('btnCan');

/* Cuando el admin le de click al botón se abrirá la ventana modal y evitar que se haga la acción de eliminar el dato */
subDel.addEventListener('click', function(e) {
    e.preventDefault(); //Evita que los datos del formulario sean enviados a PHP
    modal.classList.add('activado'); //Mostrar ventana modal
    console.log("Ventana modal abierta");
});

btnDel.addEventListener('click', function(){
    accIpt.value = 'Eliminar'; //Valor que se le da para que se conozca la acción que se va a hacer
    form.submit(); //Subir Formulario
    console.log("Dato eliminado");
});

btnCan.addEventListener('click', function(){
    modal.classList.remove('activado'); //Desaparecer ventana modal
    console.log("Cancelado");
});