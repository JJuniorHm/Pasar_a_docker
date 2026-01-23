<?php
$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
$base_url .= '://' . $_SERVER['HTTP_HOST'];
$base_url .= rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') .'/';

header("location:".$base_url);

exit();

?>