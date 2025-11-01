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

//a.2 --> Buscar ingredientes
//Declarar input del buscador
const bscIng = document.getElementById("buscador-ingrediente");
//función para normalizar texto
function removerAcento(cadena) {
    cadena = cadena.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    console.log("Se normalizo: ", cadena);
    return cadena;
}

//Evento para cuando el usuario escriba en el buscador
bscIng.addEventListener('input', () => {
    const lista = document.querySelectorAll(".lista-ing");
    //Normalizar texto
    let texto = bscIng.value.toLowerCase();
    textoNormalizado = removerAcento(texto);

    //Verificar que el input tenga texto para evitar que desaparezcan los datos
    if ( textoNormalizado.trim() !== "" ) {
        lista.forEach((lista) => {
            const spanIng = lista.querySelector(".nombre-ingrediente");
            const nombreIng = spanIng.textContent.toLowerCase();
            let nombreIngnorm = removerAcento(nombreIng);

            if(nombreIngnorm.includes(textoNormalizado)) {
                lista.style.display = "";
            } else {
                console.log("Oculto");
                lista.style.display = "none";
            }
        });
    } else {
        lista.forEach((lista) => {
            lista.style.display = "";
        })
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