<?php
if(isset($_POST['fileUrl'])) {
    $fileUrl = $_POST['fileUrl'];

    // Obtener la ruta absoluta del archivo en el servidor
    $absoluteFilePath = $_SERVER['DOCUMENT_ROOT'] . $fileUrl;

    // Elimina el archivo del servidor
    if(unlink($absoluteFilePath)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>