//Abrir ventana modal de administrador
//Obtener los elementos
const btnAdmin = document.getElementById("btn-rec-admin");
const modal = document.getElementById("modal-receta");
const divCalificar = document.getElementById("modal-calificar");
const divAdmin = document.getElementById("modal-admin");
const cerrar = document.getElementById("admin-cerrar");

btnAdmin.addEventListener("click", function() {
    modal.classList.add("activo-modal");

    divAdmin.style.display = "";
    divCalificar.style.display = "none";
});
cerrar.addEventListener("click", function() {
    modal.classList.remove("activo-modal");

    divAdmin.style.display = "none";
});