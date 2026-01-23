<?php
if(isset($_POST['groupplatform'])){
    $groupplatform = $_POST['groupplatform'];
    
    // Definir las opciones según la categoría seleccionada
    $opciones = array();
    if($groupplatform == 'gestorintegral'){
        $opciones[] = array('value' => 'tasks', 'text' => 'Tareas');
        $opciones[] = array('value' => 'userprivileges', 'text' => 'Privilegios de Usuario');
        $opciones[] = array('value'=> 'pag_register_user', 'text' =>'Registro de usuarios');
        $opciones[] = array('value' => 'signaturemail', 'text' => 'Firma para Correos');
        $opciones[] = array('value' => 'warranty', 'text' => 'Garantías');
    } elseif($groupplatform == 'backofficeweb'){
        $opciones[] = array('value' => 'events', 'text' => 'Eventos');
        $opciones[] = array('value' => 'missingimages', 'text' => 'Imágenes Faltantes');
        $opciones[] = array('value' => 'specifications', 'text' => 'Especificaciones de Producto');
        $opciones[] = array('value' => 'mainslider', 'text' => 'Carrucel de Banners');
        $opciones[] = array('value' => 'orders', 'text' => 'Pedidos');
        $opciones[] = array('value' => 'update_tb_prod', 'text' => 'Actualizar Productos');
    }
    echo json_encode($opciones);
}
?>