<?php
// Directorio donde se guardarán las imágenes
$upload_directory = 'imges/tasks/';
$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
$base_url .= '://'. $_SERVER['HTTP_HOST'];
$base_url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); // Obtiene la ruta base del archivo PHP


// Verificar si se está recibiendo un archivo
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $temp_name = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    
    // Generar un identificador único para el archivo
    $unique_id = uniqid();
    
    // Obtener la extensión del archivo original
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
    
    // Construir un nuevo nombre de archivo único
    $new_file_name = $unique_id . '.' . $file_extension;

    // Mover el archivo cargado al directorio de destino
    if (move_uploaded_file($temp_name, $upload_directory . $new_file_name)) {
        // Construir la URL completa de la imagen cargada
        $uploaded_url = $base_url . '/' . $upload_directory . $new_file_name;
        // Devolver la URL de la imagen cargada como una respuesta JSON
        echo json_encode(['location' => $uploaded_url]);
    } else {
        // Si no se pudo mover el archivo, devolver un mensaje de error
        echo json_encode(['error' => 'Error al mover el archivo']);
    }
} else {
    // Si no se recibe un archivo válido, devolver un mensaje de error
    echo json_encode(['error' => 'No se ha recibido un archivo válido']);
}
?>