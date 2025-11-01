
function anadirPaso() {
    let nuevoDiv = document.createElement("div"); //crear div
    let nuevoTitulo = document.createElement("h2"); //crear titulo
    let nuevoTextArea = document.createElement("textarea"); //crear el textarea

    nuevoDiv.append(nuevoTitulo, nuevoTextArea); //anidar los elementos dentro del div

    let divPadre = document.getElementById("form-texto");
    divPadre.insertBefore()
}