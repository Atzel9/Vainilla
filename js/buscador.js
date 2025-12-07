/* <------- Código para cambiar el tipo de busqueda y el contenedor ------->*/

//Obtener los dos botones
const btnsFiltro = document.querySelectorAll(".btn");
const input = document.getElementById("tipo");
const titulo = document.getElementById("titulo-busqueda");
const parrafo = document.getElementById("parrafo-busqueda");

function Filtro(estado) {
    const btn = document.querySelectorAll("#ingrediente button");
    const lisIng = document.getElementById("ingrediente");


    if(estado === 'usuario') {
        btn.forEach(b => {b.disabled = 'true';});
        lisIng.classList.add("ingredientes-selec-des");
    } else if (estado === 'receta') {
        btn.forEach(b => {b.disabled = '';});
        lisIng.classList.remove('ingredientes-selec-des');
    }
}

//Evento click
btnsFiltro.forEach(boton => {
    //El usuario le da click
    boton.addEventListener('click', (e) => {
        //Dar clase inactivo a todos los botones y cambiar el tipo de busqueda
        btnsFiltro.forEach(b => {
            b.classList.add("btn-tipo-desactivado"); 
            b.classList.remove("btn-tipo-activado");
        });
        //Dar clase exclusivamente al botón que el usuario le dio click
        boton.classList.add("btn-tipo-activado");
        boton.classList.remove("btn-tipo-desactivado");
        //Obtener ID del botón
        let id = e.currentTarget.id;
        console.log("Boton: ", e.currentTarget.id);

        //Cambiar el input y contenedor de resultado
        if(id === 'usuario') {
            input.name = 'usuario';
            titulo.textContent = "Buscar usuario...";
            parrafo.style.display = "none";
        } else if (id=== 'receta') {
            input.name = 'receta';
            titulo.textContent = "Buscar recetas...";
            parrafo.style.display = "";
        }

        Filtro(id);
    });
});

/* <--- Agregar Ingredientes al filtro ----> */
const btnListaing = document.getElementById("selec-ing");
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

/* Buscar ingredientes */
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
                lista.style.display = "none";
            }
        });
    } else {
        lista.forEach((lista) => {
            lista.style.display = "";
        })
    }
});

function seleccionarIngrediente (id, name) {
    const contIng = document.getElementById("ingredientes-selec");
    const nuevoCont = document.createElement("div");
    nuevoCont.setAttribute("data-id", id);
    nuevoCont.classList.add("pildora-ingrediente");

    /* Agregar datos al contenedor */
    //Texto
    const nomIng = document.createElement("p");
    nomIng.textContent = name;
    nomIng.classList.add("parrafo-ing");

    //Dato del ingrediente
    const inputIng = document.createElement("input");
    inputIng.type = "hidden";
    inputIng.name = "ingrediente[]";
    input.form = "form-busqueda";
    input.value = id;

    //Botón eliminar ingrediente
    const btnCerrar = document.createElement("button");
    btnCerrar.classList.add("btn-cerrar");
    btnCerrar.type = "button";
    btnCerrar.innerHTML = "<i class=\"ph ph-x\"></i>";

    //Evento de eliminar el ingrediente
    btnCerrar.addEventListener("click", () => {
        const idLista = nuevoCont.getAttribute("data-id");
        const listaIngId = document.querySelector(`.lista-ing[data-id="${idLista}"]`);
        if(listaIngId) {
            listaIngId.style.display = "";
        }

        nuevoCont.remove();
    });

    nuevoCont.appendChild(nomIng);
    nuevoCont.appendChild(inputIng);
    nuevoCont.appendChild(btnCerrar);

    contIng.appendChild(nuevoCont);
}

/* Agregar el ingrediente */
const nuevoIngrediente = document.querySelectorAll(".agregar-ingrediente");

nuevoIngrediente.forEach(boton => {
    boton.addEventListener("click", function() {
        //Seleccionar el contenedor padre
        const datosIng = this.closest(".lista-ing");

        //Obtener los datos para agregarlos a la función
        const id = datosIng.getAttribute("data-id");
        const name = datosIng.getAttribute("data-nombre");
        seleccionarIngrediente(id, name);

        //Ocultarlo de la lista
        datosIng.style.display = "none";
    });
});