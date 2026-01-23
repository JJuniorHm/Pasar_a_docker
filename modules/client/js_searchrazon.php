<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["Typesearch"] === "dni") {
        $ccodcli = $_POST["ccodcli"];
        
        // Validar longitud del DNI
        if (strlen($ccodcli) != 8 || !ctype_digit($ccodcli)) {
            // Responder con un mensaje de error si el DNI no es válido
            $response = array("error" => "El número de DNI debe tener 8 dígitos numéricos.");
        } else {
            // Hacer la solicitud a la API
            $url = 'https://api.apis.net.pe/v1/dni?numero=' . $ccodcli;
            $options = [
                "http" => [
                    "header" => "Content-Type: application/json"
                ]
            ];
            $context = stream_context_create($options);

            $prueba = @file_get_contents($url, false, $context);

            // Verificar si la solicitud fue exitosa
            if ($prueba === FALSE) {
                // Manejar el error, por ejemplo, registrando el error o mostrando un mensaje al usuario
                $response = array("error" => "Error al realizar la solicitud. Verifica el número de DNI y vuelve a intentarlo.");
            } else {
                // Procesar la respuesta de la API
                $data = json_decode($prueba, true);

                // Verificar si se obtuvieron datos correctamente
                if ($data && isset($data['nombres']) && isset($data['apellidoPaterno']) && isset($data['apellidoMaterno']) && isset($data['tipoDocumento']) && isset($data['numeroDocumento'])) {
                    // Dividir el campo "nombres" en partes
                    $nombres = explode(" ", $data['nombres']);
                    $nombre1 = $nombres[0];
                    $nombre2 = isset($nombres[1]) ? $nombres[1] : '';

                    // Crear un nuevo objeto con los nombres divididos
                    $newobject = array(
                        "nombre1" => $nombre1,
                        "nombre2" => $nombre2,
                        "apellidoPaterno" => $data['apellidoPaterno'],
                        "apellidoMaterno" => $data['apellidoMaterno'],
                        "tipoDocumento" => $data['tipoDocumento'],
                        "numeroDocumento" => $data['numeroDocumento']
                    );

                    // Responder con el nuevo objeto como JSON
                    $response = $newobject;
                } else {
                    // Manejar el error si no se obtuvieron datos correctamente
                    $response = array("error" => "No se pudieron obtener los datos del DNI.");
                }
            }
        }

        // Devolver la respuesta como JSON
        echo json_encode($response);
        exit();
    }
    if ($_POST["Typesearch"] === "ruc") {
        $ccodcli = $_POST["ccodcli"];
        
        // Validar longitud del RUC
        if (strlen($ccodcli) != 11 || !ctype_digit($ccodcli)) {
            // Responder con un mensaje de error si el RUC no es válido
            $response = array("error" => "El número de RUC debe tener 11 dígitos numéricos.");
        } else {
            // Hacer la solicitud a la API
            $url = 'https://api.apis.net.pe/v1/ruc?numero=' . $ccodcli;
            $options = [
                "http" => [
                    "header" => "Content-Type: application/json"
                ]
            ];
            $context = stream_context_create($options);

            $consulta = @file_get_contents($url, false, $context);

            // Verificar si la solicitud fue exitosa
            if ($consulta === FALSE) {
                // Manejar el error, por ejemplo, registrando el error o mostrando un mensaje al usuario
                $response = array("error" => "Error al realizar la solicitud. Verifica el número de RUC y vuelve a intentarlo.");
            } else {
                // Procesar la respuesta de la API
                $data = json_decode($consulta, true);

                // Verificar si la API devolvió un error
                if (isset($data['error'])) {
                    $response = array("error" => $data['error']);
                } else {
                    $response = $data;
                }
            }
        }
        
        // Devolver la respuesta como JSON
        echo json_encode($response);
        exit();
    }

}

?>
