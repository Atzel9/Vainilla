<?php
require_once "../../conexion.php";
//  Método para crear receta. Si el usuario tiene el rol de admin no va a haber necesidad de ser aceptada

if($_SERVER["REQUEST_METHOD"] === "POST") {
    //Crear receta para obtener el id de la receta
    //Obtener todos los datos de la receta
    $nombre_rta = $_POST['titulo'] ?? null;
    //Ruta de base de datos por defecto por si no se sube una imagen
    $url_bd = 'img/uploads/recetas_imagen/defecto.jpg';
    $minutos = $_POST['minuto'];
    $horas = $_POST['hora'] ?? null;
    $tiempo = null;
    $id_usuario_rta = $_SESSION['usuario_id'];

    //Verificar si el usuario subio una imagen, si no, la imagen por defecto sigue siendo la misma
    if (isset($_FILES['imagen-receta']) && $_FILES['imagen-receta']['error'] === UPLOAD_ERR_OK) {
        $ruta_bd = '../../img/uploads/recetas_imagen/';
        $imagen_og = basename($_FILES['imagen-receta']['name']);
        $extension = pathinfo($imagen_og, PATHINFO_EXTENSION);
        $nombre_unico = uniqid() . "." . $extension;
        $destino_servidor = $ruta_bd . $nombre_unico;
        $ruta_web_archivo = 'img/uploads/recetas_imagen/' . $nombre_unico;

        if (move_uploaded_file($_FILES['imagen-receta']['tmp_name'], $destino_servidor)) {
            $url_bd = $ruta_web_archivo; 
        }
    }

    //Obtener los datos del tiempo de la receta
    if($horas !== 0) {
        $tiempo = ($horas * 60) + $minutos;
    } else {
        $tiempo = $minutos;
    }
    //Subir datos de la receta para que se cree
    $sql_rec = "INSERT INTO recetas (nombre, imagen, tiempo, id_usuario) VALUES (?, ?, ?, ?)";
    $sentencia_rcta = $conexion->prepare($sql_rec);
    $sentencia_rcta->bind_param("ssis", $nombre_rta, $url_bd, $tiempo, $id_usuario_rta);
    
    if($sentencia_rcta->execute()) {
        $id_rcta_creada = $conexion->insert_id;

        //INSERTAR INGREDIENTES
        $ingredientes = $_POST['ingredientes'];
        $cantidad = $_POST['cantidad'];
        $unidad = $_POST['unidad'];

        foreach($ingredientes as $i => $id) {
            $cant = $cantidad[$i];
            $uni = $unidad[$i];

            $sql_puente = "INSERT INTO recetas_ingredientes (id_receta, id_ingrediente, cantidad, unidad) VALUES (?, ?, ?, ?)";
            $sentencia_puente = $conexion->prepare($sql_puente);
            $sentencia_puente->bind_param("iiss", $id_rcta_creada, $id, $cant, $uni);
            $sentencia_puente->execute();
            $sentencia_puente->close();
        }

        //INSERTAR PASOS
        $pasos = $_POST['paso'];

        foreach($pasos as $paso) {
            $sql_pasos = "INSERT INTO receta_pasos (id_receta, texto) VALUES (?, ?)";
            $sentencia_pasos = $conexion->prepare($sql_pasos);
            $sentencia_pasos->bind_param("is", $id_rcta_creada, $paso);
            $sentencia_pasos->execute();
            $sentencia_pasos->close();
        }
        
        //Obtener rol de usuario
        $sql_usuario_rol = "SELECT rol FROM usuarios WHERE id = ?";
        $sentencian_usuario_rol = $conexion->prepare($sql_usuario_rol);
        $sentencian_usuario_rol->bind_param("i", $_SESSION['usuario_id']);
        $sentencian_usuario_rol->execute();

        $resultado_usuario_rol = $sentencian_usuario_rol->get_result();
        $usuario_rol = $resultado_usuario_rol->fetch_assoc();

        if($usuario_rol['rol'] === 'admin') { //SI ES ADMIN LA RECETA SE SUBE SIN NECESIDAD DE REVISIÓN
            $estado = 'aprobada';
        } else if ($usuario_rol['rol'] === 'user') { //SI ES USUARIO SE SUBE A ESTADO PENDIENTE PARA QUE UN ADMIN LO ACEPTE
            $estado = 'pendiente';
        }
        $sql_rec = "UPDATE recetas SET estado = ? WHERE id_usuario = ?";
        $stmt = $conexion->prepare($sql_rec);
        $stmt->bind_param("si", $estado, $_SESSION['usuario_id']);
        $stmt->execute();
        $stmt->close();
    }
    $sentencia_rcta->close();
} else {
    header("Location: ../../index.php");
}
?>