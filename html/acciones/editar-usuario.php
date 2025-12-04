<?php

use const Dom\VALIDATION_ERR;

require_once "../../conexion.php";

//Solicitar ID del usuario
$id_perfil = $_SESSION['usuario_id'] ?? null;

if($_SERVER["REQUEST_METHOD"] === "POST") {
    //Tomar datos del formulario
    $nombre = trim($_POST["nombre"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $contrasena = trim($_POST["contrasena_nueva"] ?? "");

    //Verificar que ningun dato este vacío (exceptuando contraseña)
    if($nombre === "" && $correo === "") {
        $_SESSION["mensaje_con"] = "No se encuentran datos validos. Intente de nuevo";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) { //Validar el correo
        $_SESSION["mensaje_con"] = "Correro clectrónico no valido";
    } else {
        if($contrasena !== "") { //Actualizar datos sin contraseña nueva
            $contrasena_has = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql_act = "UPDATE usuarios
                        SET nombre = ?, correo = ?, contrasena_hash = ?
                        WHERE id = ?";
            $sentencia_act = $conexion->prepare($sql_act);
            if(!$sentencia_act) {
                $_SESSION["mensaje_con"] = "Error al actualizar datos";
            } else {
                $sentencia_act->bind_param("sssi", $nombre, $correo, $contrasena_has, $id_perfil);
                if($sentencia_act->execute()) {
                    $_SESSION["mensaje_con"] = "¡Perfil actualizado!";
                    $_SESSION["usuario_nombre"] = $nombre;
                } else {
                    if ($conexion->errno === 1062) {
                        $_SESSION["mensaje"] = "El correo ya está registrado en otro usuario.";
                    } else {
                        $_SESSION["mensaje"] = "Error al actualizar: " . $conexion->error;
                    }
                }
                $sentencia_act->close();
            }
        } else { //Sin contraseña nueva
            $sql_act = "UPDATE usuarios
                        SET nombre = ?, correo = ?
                        WHERE id = ?";
            $sentencia_act = $conexion->prepare($sql_act);
            if(!$sentencia_act) {
                $_SESSION["mensaje_con"] = "Error al actualizar datos";
            } else {
                $sentencia_act->bind_param("ssi", $nombre, $correo, $id_perfil);
                if($sentencia_act->execute()) {
                    $_SESSION["mensaje_con"] = "¡Perfil actualizado!";
                    $_SESSION["usuario_nombre"] = $nombre;
                } else {
                    if($conexion->errno === 1062) {
                        $_SESSION["mensaje_con"] = "El correo ya esta registrado en otro usuario";
                    } else {
                        $_SESSION["mensaje_con"] = "Error al actualizar " . $conexion->error;
                    }
                }
                $sentencia_act->close();
            }
        }
    }
    header("Location: ../configuracion.php");
} else {
    header("Location: ../configuracion.php");
}
?>