<?php

include 'class.php';
include "../../modules/GlobalClass/privileges.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if(!empty($_SESSION['ucoduser'])){
    $coduser = $_SESSION['ucoduser'];
  }

// include "class_insertclient.php";
// $class_insert = new class_insertClient();

  $orders = new orders();
  $Privileges = new Privileges();

  $Privileges->setCodUser( "0002" );
  $checkvp = $Privileges->validate_privileges_in_orders();

  if($checkvp && $checkvp->num_rows == 1){
    $get_orders = $orders->get_orders();

    $list_courses = '
    <div class="accordion accordion-flush" id="accordionFlushExample">
    ';
    $list_products = '';
    $list_clientguest = '';
    foreach ($get_orders as $order) {
  
      $pdatecreate = $order['pdatecreate'];
      $date = new DateTime($pdatecreate);
      $fecha_formateada = $date->format('d-m-y g:i a');
      $orders->setpcodped($order['pcodped']);
      $get_listclientguest = $orders->get_listclientguest();
      $get_listproducts = $orders->get_listproducts();
      $list_products = '
      <table class="table">
      <thead>
        <tr>
          <th scope="col">Código</th>
          <th scope="col">Decripción</th>
          <th scope="col">Valor</th>
        </tr>
      </thead>
      <tbody>
      ';
      foreach ($get_listclientguest as $listclientguest) {
        $list_clientguest .= '
        <div class="card mb-3 shadow">
          <div class="card-header text-center h5">
            Datos del cliente
          </div>
          <div class="card-body ">
            <div class="row">
              <div class="col-12 col-md-6 py-2 text-center">
                '.$listclientguest['crazon'].'
              </div>
              <div class="col-12 col-md-6 py-2  text-center">
              '.$listclientguest['cdireccion'].'
              </div>
              <div class="col-12 col-md-6 py-2 text-center">
                '.$listclientguest['ctelefono1'].' / '.$listclientguest['ctelefono2'].' 
              </div>
              <div class="col-12 col-md-6 py-2  text-center">
              '.$listclientguest['ccorreo'].'
              </div>
              <div class="col-12 col-md-6 py-2 text-center">
                '.$listclientguest['c_departamento'].' 
              </div>
              <div class="col-12 col-md-6 py-2  text-center">
              '.$listclientguest['c_provincia'].'
              </div>
              <div class="col-12 col-md-6 py-2  text-center">
              '.$listclientguest['c_distrito'].'
              </div>
              <div class="col-12 col-md-6 py-2  text-center">
              '.$listclientguest['c_codigopostal'].'
              </div>
            </div>
          </div>
          
        </div>
        ';
      }
      foreach ($get_listproducts as $listproducts) {
        $list_products .= '
        <tr> 
        <td>'.$listproducts['codigo'].'</td>
        <td class="text-truncate">'.$listproducts['descripcion'].'</td>
        <td>S/ '.$listproducts['ptpreciototal'].'</td>
        </tr>
        ';
      }
  
      $list_courses .= '
        <div class="accordion-item">
          <h2 class="accordion-header " id="flush-headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#order_'.$order['pcodped'].'" aria-expanded="false" aria-controls="order_'.$order['pcodped'].'">
                Pedido registrado el: '.$fecha_formateada.'
            </button>
          </h2>
          <div id="order_'.$order['pcodped'].'" class="accordion-collapse collapse p-4" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            '.$list_clientguest.'
            <div class="card mb-2 shadow">
              <div class="card-header text-center h5">
              Lista de Productos
              </div>
              <div class="card-body">
                      '.$list_products.'
                      <tr> 
                      <td></td>
                      <td class="h5">Total</td>
                      <td>S/ '.$order['ptotal'].'</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      ';
      $list_products = '';
      $list_clientguest = '';
    }
  
    $list_courses .= '</div>';
  
    if (!empty($_POST['action']) && $_POST['action'] == 'list_orders' ) {
      echo json_encode(array( 'status' => true, 'message' => $list_courses ));
      exit();
    }
    if (!empty($_POST['action']) && $_POST['action'] == 'Introducción a la Gestión de Ventas' ) {
      echo json_encode(array( 'status' => true, 'message' => $container_courses ));
      exit();
    }
  } else {
    $resulthtml = '<div class="text-danger">No tienes los privilegios suficientes para acceder a esta Zona.</div>';
  }
    $response = array('status' => true, 'message' => $resulthtml ); 
    echo json_encode($response);


}
