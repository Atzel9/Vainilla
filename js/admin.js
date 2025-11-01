/* Definir botones del html */
const btnIng = document.getElementById('btnIng');
const btnRec = document.getElementById('btnRec');
const btnUsu = document.getElementById('btnUsu');
/* Definir contenedores del html */
const inicio = document.getElementById('vacio');
const ingrediente = document.getElementById('ingrediente');
const receta = document.getElementById('recetas');
const usuarios = document.getElementById('usuarios');

/* Evento al boton de ingredientes */
btnIng.addEventListener('click', () => {
    /* Hacerlos visibles y mostrar al botón activo */
    btnIng.classList.add('btn-activo');
    ingrediente.classList.add('div-activo');

    /* Ocultar los otros botones */
    inicio.classList.remove('div-activo');
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
    inicio.classList.remove('div-activo');
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
    inicio.classList.remove('div-activo');
    btnRec.classList.remove('btn-activo');
    receta.classList.remove('div-activo');
    btnIng.classList.remove('btn-activo');
    ingrediente.classList.remove('div-activo');
});

/* Código para el buscador de ingredientes */
/* Función para eliminar acento */
function removerAcento(cadena) {
    cadena = cadena.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    console.log("Se normalizo: ", cadena);
    return cadena;
}

/* TOMAR VALOR DEL INPUT */
const iptBus = document.getElementById('admin-buscar');

/* EVENTO DE QUE CUANDO EL VALOR DEL INPUT CAMBIE ESTE SE ACTIVE */
iptBus.addEventListener("input", function(){
    console.log("Evento input");
    const tablaIngrediente = document.getElementById('tabla-ingrediente');
    const lista = tablaIngrediente.querySelectorAll("tbody tr");
    /* Normalizar el texto */
    let texto = iptBus.value.toLowerCase();
    textoNormalizado = removerAcento(texto);

    /* Verifica que el texto tenga texto */
    if (textoNormalizado.trim() !== "") {
        lista.forEach((lista) => {
            const nombre = lista.querySelector(".nombre");
            const textoCelda = nombre.textContent.toLowerCase();
            let textoCeldaNorm = removerAcento(textoCelda);

            if(textoCeldaNorm.includes(textoNormalizado)) {
                lista.style.display = "";
            } else {
                lista.style.display = "none";
            }
        });
    } else {
        lista.forEach((lista) => {
            lista.style.display = "";
        });
    }
});