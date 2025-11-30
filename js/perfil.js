document.addEventListener('DOMContentLoaded', () => {
    //Identificar a todos los botones que tienen la clase .btn-perfil
    const botones = document.querySelectorAll(".btn-perfil");

    //Ir por cada botón
    botones.forEach(boton => {
        //El usuario le da click
        boton.addEventListener('click', () => {
            //Dar clase inactivo a todos los botones
            botones.forEach(b => {b.classList.add("btn-inactivo")});
            //Dar clase exclusivamente al botón que el usuario le dio click
            boton.classList.add("btn-activo");
            boton.classList.remove("btn-inactivo");
            console.log("click");
        });
    });
});