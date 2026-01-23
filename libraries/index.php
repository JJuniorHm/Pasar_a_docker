<?php

$root_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
$root_url .= '://' . $_SERVER['HTTP_HOST'];

//echo ROOT_URL;
// Redireccionar a ROOT_URL
header('Location: ' . $root_url);
exit();
?>