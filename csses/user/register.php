<?php
exit('no se usa')
require_once "../../cfig.php";
require_once "../../csses/class_lgin/user.php";

if ($_POST) {

$dni = $_POST['udni'];
$correo = $_POST['ucorreo'];
$pass = password_hash($_POST['upassword'], PASSWORD_DEFAULT);
$nombre = $_POST['unombre1'];
$paterno = $_POST['upaterno'];
$materno = $_POST['umaterno'];

$sql = "INSERT INTO users 
        (udni, ucorreo, upassword, unombre1, upaterno, umaterno, u_datecreate)
        VALUES (?, ?, ?, ?, ?, ?, NOW())";

$stmt = $cnx->prepare($sql);
$stmt->bind_param("ssssss", $dni, $correo, $pass, $nombre, $paterno, $materno);

if ($stmt->execute()) {
    echo "Usuario registrado correctamente";
} else {
    echo "Error al registrar usuario";
}
}


