<?php
require_once "../../conexion.php";

if($_SERVER["REQUEST_METHOD"] === 'POST') {
    $busqueda = trim($_POST["buscar"] ?? "");
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
        
        if(empty($busqueda) && empty($ingredientes)) { //Si no hay datos devolver lo mismo
            
            //Estructura html
            $html = <<<HTML
            <h2 id="titulo-busqueda">Buscar recetas...</h2>
            <p id="parrafo-busqueda">$total_recetas_html  recetas disponibles.</p>

            HTML;

            echo $html;
        } 
        elseif(!empty($busqueda) && !empty($ingredientes)) { //Busqueda con texto e ingrediente
            //Estructura html
            $html = '';
                foreach($ingredientes as $ingrediente) {
                    $html .= <<<HTML
                        <h2 id="titulo-busqueda">{$ingrediente}</h2>
                        <p>{$busqueda}</p>
                    HTML;
                }
            echo $html;
        }
        elseif(!empty($busqueda) && empty($ingredientes)) { //Busqueda por solo texto
            echo  '<h2 id="titulo-busqueda">Solo texto</h2>' ;
        } 
        elseif(empty($busqueda) && !empty($ingredientes)) { //Busqueda por solo ingrediente(s)
            //Estructura html para mostrar resultado
            $html = '';
                foreach($ingredientes as $ingrediente) {
                    $html .= <<<HTML
                        <h2 id="titulo-busqueda">{$ingrediente}</h2>
                        <p>Solo ing</p>
                    HTML;
                }
            echo $html;
        }
    } elseif ($tipo === 'usuario') {
        if(empty($busqueda)) {
            //Estructura html
            $html = <<<HTML
            <h2 id="titulo-busqueda">Buscar usuarios...</h2>
            HTML;

            echo $html;
        }
    }
}


?>