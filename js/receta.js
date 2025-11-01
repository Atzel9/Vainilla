/*----SECCIÓN----*/
/*a) 
1.Mostrar/Ocular lista de ingredientes
2.Buscador para la lista de ingredientes
3.Agregar ingrediente en el contenedor "ingredientes-seleccionados"
*/

//a.1 --> Mostrar/Ocultar lista de ingredientes
const btnListaing = document.getElementById("btn-lista-ing");
const divListaing = document.getElementById("lis-rec");
let btnEstado = false;

//Mostrar/Ocultar mediante el botón
btnListaing.addEventListener ("click", function(){
    if (btnEstado === false) {
        btnEstado = true;
        console.log(btnEstado);
        divListaing.classList.remove("lista-desactiva");
        divListaing.classList.add("lista-activa");
    } else if (btnEstado === true) {
        btnEstado = false;
        console.log(btnEstado);
        divListaing.classList.remove("lista-activa");
        divListaing.classList.add("lista-desactiva");
    }
});

//Ocultar si se da click fuera del contenedor
window.addEventListener('click', (e) => {
    if(!divListaing.contains(e.target) && e.target !== btnListaing) {
        btnEstado = false;
        console.log(btnEstado);
        divListaing.classList.remove("lista-activa");
        divListaing.classList.add("lista-desactiva");
    }
});

function anadirPaso() {
    let nuevoDiv = document.createElement("div"); //crear div
    let nuevoTitulo = document.createElement("h2"); //crear titulo
    let nuevoTextArea = document.createElement("textarea"); //crear el textarea

    nuevoDiv.append(nuevoTitulo, nuevoTextArea); //anidar los elementos dentro del div

    let divPadre = document.getElementById("form-texto");
    divPadre.insertBefore()
}