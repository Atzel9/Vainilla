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
                lista.style.display = "none";
            }
        });
    } else {
        lista.forEach((lista) => {
            lista.style.display = "";
        })
    }
});

//a. -> Agregar ingredientes

//función para agregar el contenedor
function agregarIngrediente(id, ingrediente){
    const contIngrediente = document.getElementById("ingredientes-seleccionados");
    const nuevoContIng = document.createElement("div");
    nuevoContIng.classList.add("div-ing-seleccionado");
    nuevoContIng.setAttribute("data-id", id);
    nuevoContIng.setAttribute("data-ingrediente", ingrediente);

    //Crear los elementos que estarán dentro del div
    //Span
    const spanNombre = document.createElement("span");
    spanNombre.textContent = ingrediente;
    spanNombre.classList.add("span-ing");
    //Input number
    const inputNum = document.createElement("input");
    inputNum.type = "number";
    inputNum.min = "1";
    inputNum.value = "1";
    inputNum.classList.add("ipt-cantidad-ing");
    //Input tipo de unidad
    const tipUnidad = document.createElement("select");
    tipUnidad.classList.add("tipo-unidad");

    const valores = [
        { valor: 'g', texto: 'g' },
        { valor: 'mg', texto: 'mg' },
        { valor: 'kg', texto: 'kg' },
        { valor: 'oz', texto: 'oz' },
        { valor: 'lb', texto: 'lb' },
        { valor: 'l', texto: 'l' },
        { valor: 'ml', texto: 'ml' },
        { valor: 'fl oz', texto: 'fl oz' },
        { valor: 'tsp', texto: 'cucharadita (tsp)' },
        { valor: 'tbsp', texto: 'cucharada (tbsp)' },
        { valor: 'cup', texto: 'taza (cup)' },
        { valor: 'pinch', texto: 'pizca' },
        { valor: 'dash', texto: 'dash' },
        { valor: 'unidad', texto: 'unidad(es)' } // para huevos, vainas, hojas, etc.
    ];

    valores.forEach(unidad => {
        const opcion = document.createElement("option");
        opcion.value = unidad.valor;
        opcion.textContent = unidad.texto;
        tipUnidad.appendChild(opcion);
    });
    //Input cerrar
    const eliminarIng = document.createElement("button");
    eliminarIng.classList.add("btn-eliminar-ing");
    eliminarIng.type = "button";
    eliminarIng.name = "btnIngrediente";
    eliminarIng.innerHTML = "<i class=\"ph ph-x\"></i>";

    //Eliminar contenedor
    eliminarIng.addEventListener('click', () => {
        const idOg = nuevoContIng.getAttribute("data-id");
        const listaIngId = document.querySelector(`.lista-ing[data-id="${idOg}"]`);
        if(listaIngId) {
            listaIngId.style.display = "";
        }

        nuevoContIng.remove();
    });

    //Anidar los elementos
    nuevoContIng.appendChild(spanNombre);
    nuevoContIng.appendChild(inputNum);
    nuevoContIng.appendChild(tipUnidad);
    nuevoContIng.appendChild(eliminarIng);

    contIngrediente.appendChild(nuevoContIng);
}

//Evento de cuando el usuario le da click al ingrediente
const btnAgregar = document.querySelectorAll(".agregar-ingrediente");

btnAgregar.forEach(boton => {
    boton.addEventListener('click', function() {
        console.log("Click");
        //Buscar el ancestro que tenga la clase en el parametro
        const OpcionIng = this.closest(".lista-ing");

        //Obtener los atributos
        const id = OpcionIng.getAttribute("data-id");
        const nombre = OpcionIng.getAttribute("data-nombre");

        //Agregar esos atributos a los parametros de la función y se cree el objeto
        agregarIngrediente(id, nombre);

        OpcionIng.style.display = "none";
    });
});

function anadirPaso() {
    let nuevoDiv = document.createElement("div"); //crear div
    let nuevoTitulo = document.createElement("h2"); //crear titulo
    let nuevoTextArea = document.createElement("textarea"); //crear el textarea

    nuevoDiv.append(nuevoTitulo, nuevoTextArea); //anidar los elementos dentro del div

    let divPadre = document.getElementById("form-texto");
    divPadre.insertBefore()
}