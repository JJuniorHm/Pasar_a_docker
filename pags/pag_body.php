<?php
if(!defined("pag_body"))
{
    header("Location: /index.php");
    exit();
} 
?>

<div class="cardspagbody">

    <a class="body_card" href="?p=pag_register_user">
        REGISTRO DE USUARIOS
    </a>

    <a class="body_card" href="?p=pag_userprivileges">
        PRIVILEGIOS GI
    </a>

    <a class="body_card" href="?p=pag_taskmnger">
        TAREAS Y PROYECTOS
    </a>

    <a class="body_card" href="?p=pag_warranty">
        GARANTÍAS
    </a>

</div>
