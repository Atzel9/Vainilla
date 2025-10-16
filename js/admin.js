/* Definir botones del html */
const btnIng = document.getElementById('btnIng');
const btnRec = document.getElementById('btnRec');
const btnUsu = document.getElementById('btnUsu');
/* Definir contenedores del html */
const ingrediente = document.getElementById('ingrediente');
const receta = document.getElementById('recetas');
const usuarios = document.getElementById('usuarios');

/* Evento al boton de ingredientes */
btnIng.addEventListener('click', () => {
    /* Hacerlos visibles y mostrar al botón activo */
    btnIng.classList.add('btn-activo');
    ingrediente.classList.add('div-activo');

    /* Ocultar los otros botones */
    btnRec.classList.remove('btn-activo');
    receta.classList.remove('div-activo');
    btnUsu.classList.remove('btn-activo');
    usuarios.classList.remove('div-activo');
});

/* Evento al botón de recetas */
btnRec.addEventListener('click', () => {
    /* Hacerlos visibles y mostrar al botón activo */
    btnRec.classList.add('btn-activo');
    receta.classList.add('div-activo');

    /* Ocultar los otros botones */
    btnIng.classList.remove('btn-activo');
    ingrediente.classList.remove('div-activo');
    btnUsu.classList.remove('btn-activo');
    usuarios.classList.remove('div-activo');
});

/* Evento al botón usuarios */
btnUsu.addEventListener('click', () => {
    /* Hacerlos visibles y mostrar al botón activo */
    btnUsu.classList.add('btn-activo');
    usuarios.classList.add('div-activo');

    /* Ocultar los otros botones */
    btnRec.classList.remove('btn-activo');
    receta.classList.remove('div-activo');
    btnIng.classList.remove('btn-activo');
    ingrediente.classList.remove('div-activo');
});