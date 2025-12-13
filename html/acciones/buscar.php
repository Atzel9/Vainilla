<?php
require_once "../../conexion.php";
$html  = '';

if($_SERVER["REQUEST_METHOD"] === 'POST') {
    $busqueda = trim($_POST["buscar"] ?? "");
    $bus_sql = "%" . $busqueda . "%"; //Busqueda para el sql
    $tipo = $_POST["tipo"] ?? "";

    if ($tipo === 'receta') {
        /* Solicitar número de recetas */
        $aprobada = 'aprobada';
        $sentencia_recetas = $conexion->prepare("SELECT COUNT(*) AS recetas FROM recetas WHERE estado = ? ");
        $sentencia_recetas->bind_param("s", $aprobada);
        $sentencia_recetas->execute();

        $resultado_rec = $sentencia_recetas->get_result();
        $recetas = $resultado_rec->fetch_assoc();
        $total_recetas = $recetas["recetas"];
        $total_recetas_html = htmlspecialchars($total_recetas, ENT_QUOTES, 'UTF-8');

        $ingredientes = $_POST['ingrediente'] ?? [];
        $html = ''; /* Inicializar variable contenible */
        
        if(empty($busqueda) && empty($ingredientes)) { //Si no hay datos devolver lo mismo
            //Estructura html
            $html = <<<HTML
            <h2 id="titulo-busqueda">Buscar recetas...</h2>
            <p id="parrafo-busqueda">$total_recetas_html  recetas disponibles.</p>

            HTML;

            echo $html;
        } 
        elseif(!empty($busqueda) && !empty($ingredientes)) { //Busqueda con texto e ingrediente
            /* <---- BUSCAR ----> */
            /* Tranformar los ingredientes en '?' para que se pueda buscar con los ingredientes */
            $placeholders_ing = implode(',', array_fill(0, count($ingredientes), '?'));
            $estado = 'aprobada';
            $sql_recetas = 
            "SELECT r.id, r.nombre, r.imagen, r.tiempo, r.id_usuario,
            u.nombre AS nombre_usuario
            FROM recetas r 
            INNER JOIN usuarios u ON r.id_usuario = u.id
            INNER JOIN recetas_ingredientes ri ON r.id = ri.id_receta
            INNER JOIN ingredientes i ON ri.id_ingrediente = i.id
            WHERE 
            ri.id_ingrediente IN ($placeholders_ing) #Lista de ingredientes con '?'
            AND r.nombre LIKE ? #Nombre
            AND r.estado = ? #El estado que debe de ser aceptado
            GROUP BY r.id";
            $sentencia = $conexion->prepare($sql_recetas);
            $tipos_param = str_repeat('i', count($ingredientes)) . "ss";
            $parametro = array_merge($ingredientes, [$bus_sql, $estado]);
            $sentencia->bind_param($tipos_param, ...$parametro);

            if($sentencia->execute()) {
                $resultado_bus = $sentencia->get_result();
                //Estructura final html
                if($resultado_bus->num_rows > 0) {
                    while($recetas_bus = $resultado_bus->fetch_assoc()) {
                        $id_html = htmlspecialchars($recetas_bus['id'], ENT_QUOTES, 'UTF-8');
                        $nombre_html = htmlspecialchars($recetas_bus['nombre'], ENT_QUOTES, 'UTF-8');
                        $nombreUsu_html = htmlspecialchars($recetas_bus['nombre_usuario'], ENT_QUOTES, 'UTF-8');
                        $imagen_html = htmlspecialchars($recetas_bus['imagen'], ENT_QUOTES, 'UTF-8');
                        $tiempo = (int)($recetas_bus['tiempo']);
                        if($tiempo >= 60) {
                            $horas = intval($tiempo / 60);
                            $minutos = $tiempo % 60;

                            $tiempo_adaptado = "{$horas}h {$minutos}min";
                        } else {
                            $tiempo_adaptado = "{$tiempo}min";
                        }
                        $html .= <<<HTML
                            <a class="enlace-rec" href="receta.php?id={$id_html}">
                                <div class="cont-receta">
                                    <div class="img-receta">
                                        <img class="imagen-receta" src="../{$imagen_html}" alt="">
                                    </div>
                                    <div class="texto-receta">
                                        <div class="receta-titulo"><h2>{$nombre_html}</h2></div>
                                        <div class="receta-datos">
                                            <div class="detalles">
                                                <div class="usuario-rec">
                                                    <p>@{$nombreUsu_html}</p>
                                                </div>
                                                <div class="detalles-datos">
                                                    <div class="pildora-det">
                                                        <p><i class="ph ph-hourglass-simple"></i>{$tiempo_adaptado}</p>
                                                        <p><i class="ph ph-star"></i>5.0</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        HTML;
                    }
                echo $html;
            } else {
                echo 'No se encontraron recetas';
            }
            } else {
                //Estructura final html
                $html .= <<<HTML
                    <h2 id="titulo-busqueda">Ocurrio un error al buscar la receta.</h2>
                    <h3>Intente de nuevo mas tarde</h3>
                    HTML;
                echo $html;
            }
        }
        elseif(!empty($busqueda) && empty($ingredientes)) { //Busqueda por solo texto
            /* DATOS PARA HCAER EL BUSQUEDA */
            $estado = 'aprobada';
            $sql_recetas = 
            "SELECT r.id, r.nombre, r.imagen, r.tiempo, r.id_usuario,
            u.nombre AS nombre_usuario
            FROM recetas r 
            INNER JOIN usuarios u ON r.id_usuario = u.id
            WHERE r.nombre LIKE ? AND r.estado = ?
            GROUP BY r.id";
            $sentencia_busqueda = $conexion->prepare($sql_recetas);
            $sentencia_busqueda->bind_param("ss", $bus_sql, $estado);
            if($sentencia_busqueda->execute()) {
                $resultado_bus = $sentencia_busqueda->get_result();
                if($resultado_bus->num_rows > 0) {
                    while($recetas_bus = $resultado_bus->fetch_assoc()) {
                        $id_html = htmlspecialchars($recetas_bus['id'], ENT_QUOTES, 'UTF-8');
                        $nombre_html = htmlspecialchars($recetas_bus['nombre'], ENT_QUOTES, 'UTF-8');
                        $nombreUsu_html = htmlspecialchars($recetas_bus['nombre_usuario'], ENT_QUOTES, 'UTF-8');
                        $imagen_html = htmlspecialchars($recetas_bus['imagen'], ENT_QUOTES, 'UTF-8');
                        $tiempo = (int)($recetas_bus['tiempo']);
                        if($tiempo >= 60) {
                            $horas = intval($tiempo / 60);
                            $minutos = $tiempo % 60;

                            $tiempo_adaptado = "{$horas}h {$minutos}min";
                        } else {
                            $tiempo_adaptado = "{$tiempo}min";
                        }
                        $html .= <<<HTML
                            <a class="enlace-rec" href="receta.php?id={$id_html}">
                                <div class="cont-receta">
                                    <div class="img-receta">
                                        <img class="imagen-receta" src="../{$imagen_html}" alt="">
                                    </div>
                                    <div class="texto-receta">
                                        <div class="receta-titulo"><h2>{$nombre_html}</h2></div>
                                        <div class="receta-datos">
                                            <div class="detalles">
                                                <div class="usuario-rec">
                                                    <p>@{$nombreUsu_html}</p>
                                                </div>
                                                <div class="detalles-datos">
                                                    <div class="pildora-det">
                                                        <p><i class="ph ph-hourglass-simple"></i>{$tiempo_adaptado}</p>
                                                        <p><i class="ph ph-star"></i>5.0</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        HTML;
                    }
                echo $html;
            } else {
                echo 'No se encontraron recetas';
            }
            } else {
                //Estructura final html por si ocurrio error
                $html = <<<HTML
                    <h2 id="titulo-busqueda">Ocurrio un error al buscar la receta.</h2>
                    <h3>Intente de nuevo mas tarde</h3>
                    HTML;
                echo $html;
            }
        } 
        elseif(empty($busqueda) && !empty($ingredientes)) { //Busqueda por solo ingrediente(s)
            /* <---- BUSCAR ----> */
            /* Tranformar los ingredientes en '?' para que se pueda buscar con los ingredientes */
            $placeholders_ing = implode(',', array_fill(0, count($ingredientes), '?'));
            $estado = 'aprobada';
            $sql_recetas = 
            "SELECT r.id, r.nombre, r.imagen, r.tiempo, r.id_usuario,
            u.nombre AS nombre_usuario
            FROM recetas r 
            INNER JOIN usuarios u ON r.id_usuario = u.id
            INNER JOIN recetas_ingredientes ri ON r.id = ri.id_receta
            INNER JOIN ingredientes i ON ri.id_ingrediente = i.id
            WHERE 
            ri.id_ingrediente IN ($placeholders_ing) #Lista de ingredientes con '?'
            AND r.estado = ? #El estado que debe de ser aceptado
            GROUP BY r.id";
            $sentencia = $conexion->prepare($sql_recetas);
            $tipos_param = str_repeat('i', count($ingredientes)) . "s";
            $parametro = array_merge($ingredientes, [$estado]);
            $sentencia->bind_param($tipos_param, ...$parametro);

            if($sentencia->execute()) {
                $resultado_bus = $sentencia->get_result();
                //Estructura final html
                if($resultado_bus->num_rows > 0) {
                    while($recetas_bus = $resultado_bus->fetch_assoc()) {
                        $id_html = htmlspecialchars($recetas_bus['id'], ENT_QUOTES, 'UTF-8');
                        $nombre_html = htmlspecialchars($recetas_bus['nombre'], ENT_QUOTES, 'UTF-8');
                        $nombreUsu_html = htmlspecialchars($recetas_bus['nombre_usuario'], ENT_QUOTES, 'UTF-8');
                        $imagen_html = htmlspecialchars($recetas_bus['imagen'], ENT_QUOTES, 'UTF-8');
                        $tiempo = (int)($recetas_bus['tiempo']);
                        if($tiempo >= 60) {
                            $horas = intval($tiempo / 60);
                            $minutos = $tiempo % 60;

                            $tiempo_adaptado = "{$horas}h {$minutos}min";
                        } else {
                            $tiempo_adaptado = "{$tiempo}min";
                        }
                        $html .= <<<HTML
                            <a class="enlace-rec" href="receta.php?id={$id_html}">
                                <div class="cont-receta">
                                    <div class="img-receta">
                                        <img class="imagen-receta" src="../{$imagen_html}" alt="">
                                    </div>
                                    <div class="texto-receta">
                                        <div class="receta-titulo"><h2>{$nombre_html}</h2></div>
                                        <div class="receta-datos">
                                            <div class="detalles">
                                                <div class="usuario-rec">
                                                    <p>@{$nombreUsu_html}</p>
                                                </div>
                                                <div class="detalles-datos">
                                                    <div class="pildora-det">
                                                        <p><i class="ph ph-hourglass-simple"></i>{$tiempo_adaptado}</p>
                                                        <p><i class="ph ph-star"></i>5.0</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        HTML;
                    }
                echo $html;
            } else {
                $html = <<<HTML
                    <h2 id="titulo-busqueda">No se encontraron recetas.</h2>
                HTML;
            }
            } else {
                //Estructura final html
                $html = <<<HTML
                    <h2 id="titulo-busqueda">Ocurrio un error al buscar la receta.</h2>
                    <h3>Intente de nuevo mas tarde</h3>
                    HTML;
                echo $html;
            }
        }
    } elseif ($tipo === 'usuario') { #Lógica para la busqueda que es tipo usuario
        if(!empty($busqueda)) {
            $sql_usu = 
            "SELECT u.*, COUNT(r.id) AS total_recetas
            FROM usuarios u
            LEFT JOIN recetas r ON u.id = r.id_usuario AND r.estado = 'aprobada'
            WHERE u.nombre LIKE ?
            GROUP BY u.id, u.nombre";
            $sentencia_usuarios = $conexion->prepare($sql_usu);
            $sentencia_usuarios->bind_param("s", $bus_sql);
            if($sentencia_usuarios->execute()) {
                $resultado_bus = $sentencia_usuarios->get_result();
                if($resultado_bus->num_rows > 0) {
                    while($usuario = $resultado_bus->fetch_assoc()) {
                        $id_html = htmlspecialchars($usuario['id'], ENT_QUOTES, 'UTF-8');
                        $nombre_html = htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8');
                        $total_recetas_html = htmlspecialchars($usuario['total_recetas'], ENT_QUOTES, 'UTF-8');
                        $html .= <<<HTML
                            <a href>
                                <div class="usuario-busqueda">
                                    <p>$id_html</p>
                                    <p>$nombre_html</p>
                                    <p>Recetas creadas: $total_recetas_html</p>
                                </div>
                            </a>
                        HTML;
                    }
                    echo $html;
                } else { #No se encontraron usuarios
                    $html = <<<HTML
                        <h2 id='titulo-busqueda' >No se encontraron usuarios</h2>
                    HTML;
                    echo $html;
                }
            } else {
                $html = <<<HTML
                    <h2 id="titulo-busqueda">Ocurrio un error al buscar la receta.</h2>
                    <h3>Intente de nuevo mas tarde</h3>
                    HTML;
                echo $html;
            }
        }
        elseif(empty($busqueda)) {
            //Estructura html
            $html = <<<HTML
            <h2 id="titulo-busqueda">Buscar usuarios...</h2>
            HTML;

            echo $html;
        }
    }
}


?>