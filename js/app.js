//Abrir ventana modal cuando el usuario no tienen iniciada sesión
const modal = document.getElementById("nav-modal");
const btns = document.querySelectorAll(".nav-btn");
const cerrar = document.getElementById("cerrar");

//Seleccionar los 3 botones que abre la ventana modal
btns.forEach(boton => {
    boton.addEventListener('click', () =>{
        modal.classList.add('activo');
        console.log("Ventana modal abierta");
    });
});

cerrar.addEventListener('click', () => {
    modal.classList.remove('activo');
});