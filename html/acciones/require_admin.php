<?php
/*Acción para verificar que la sesión inicidia tenga permiso para acceder a está página.*/

//PRIMERO: Verificar que haya iniciado sesión
if(!isset($_SESSION['usuario_id'])) {
    header("Location: /bootcamp/Vainilla/html/iniciar_sesion.php");
} else {
    //Verificar que tenga el rol de admin
    $id = $_SESSION['usuario_id'];
    $nombre_usuario = $_SESSION['usuario_nombre'];
    $sql_rol = "SELECT rol FROM usuarios WHERE id=?";
    $sentencia_rol = $conexion->prepare($sql_rol);
    $sentencia_rol->bind_param("i", $id);
    $sentencia_rol->execute();

    $resultado_rol = $sentencia_rol->get_result();
    $usuario = $resultado_rol->fetch_assoc();

    if($usuario['rol'] != 'admin') { //Verifica el rol
        header("Location: /bootcamp/Vainilla/html/acciones/error.php?error=rol");
    }
    $sentencia_rol->close();
}
?>