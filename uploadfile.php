<?php
// Manejo de archivos permitidos
$allowedExtensions = array(
    "doc" => "<i class='bx bxs-file-doc'></i>",
    "docx" => "<i class='bx bxs-file-doc'></i>",
    "xls" => "<i class='bx bxs-file'></i>",
    "xlsx" => "<i class='bx bxs-file'></i>",
    "pdf" => "<i class='bx bxs-file-pdf'></i>"
);

if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"];
} else {
    $fileName = $_FILES["file"]["name"];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueCode = uniqid(); // Genera un código único

    // Verifica si la extensión del archivo está permitida
    if (array_key_exists($fileExtension, $allowedExtensions)) {
        $targetDirectory = "fles/tasks/";
        $targetFile = $targetDirectory . $uniqueCode . "_" . $fileName; // Agrega el código único al nombre del archivo

        // Mueve el archivo a la carpeta de destino
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $fileUrl = dirname($_SERVER['REQUEST_URI']) . "/" . $targetFile; // Obtiene la URL relativa del archivo
            $fileName = htmlspecialchars($fileName); // Escapa caracteres especiales en el nombre del archivo por seguridad

            $nombreArchivo = $fileName;

            // Longitud máxima deseada después del recorte
            $longitudMaxima = 30;

            // Verificamos si es necesario recortar el nombre del archivo
            if (strlen($nombreArchivo) > $longitudMaxima) {
                // Longitud de la porción que se mostrará antes y después de los puntos suspensivos
                $longitudMostrar = floor(($longitudMaxima - 3) / 2);

                // Extraemos la parte inicial del nombre del archivo
                $parteInicial = substr($nombreArchivo, 0, $longitudMostrar);

                // Extraemos la parte final del nombre del archivo
                $parteFinal = substr($nombreArchivo, -$longitudMostrar);

                // Generamos el nuevo nombre del archivo con puntos suspensivos
                $nuevoNombre = $parteInicial . "..." . $parteFinal;
            } else {
                // Si el nombre del archivo ya es menor o igual a la longitud máxima deseada,
                // no es necesario recortarlo
                $nuevoNombre = $nombreArchivo;
            }

            //Con
            // $downloadLink = '<div class="dns_ctnerbtndownloadfile"><i class="bx bx-x"></i><a href="' . $fileUrl . '" download class="dns_btndownloadfile">' . $allowedExtensions[$fileExtension] . '<span class="dns_ttledownloadfile">' . $nuevoNombre . '</span></a></div>';

            $downloadLink = '<div class="dns_ctnerbtndownloadfile"><i class="bx bx-x"></i><a href="' . $fileUrl . '" download class="dns_btndownloadfile">' . $allowedExtensions[$fileExtension] . '<span class="dns_ttledownloadfile">' . $nuevoNombre . '</span></a></div>';

            // Devuelve la etiqueta <a> como respuesta junto con la URL
            echo json_encode(array( 'downloadLink' => $downloadLink, 'fileUrl' => $fileUrl ));
        } else {
            echo "Error al cargar el archivo.";
        }
    } else {
        echo "Tipo de archivo no permitido.";
    }
}
?>
