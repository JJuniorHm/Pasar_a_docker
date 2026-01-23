<?php

if(!defined("pag_warranty"))
{
    header("Location: /index.php");
    exit();
}

include "modules/warranty/classes/warranty.php";

$warranty = new warranty();

if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$csvar_cdna_bcdor = null;

$warranty->setCodUser($coduser);
$listcards = $warranty->GetList();

$ctinerclumns = array(
  "GESTIÓN DE INTERNAMIENTO",
  "GESTIÓN DE ENVÍO: PROVEEDOR",
  "GESTIÓN DE RETORNO: PROVEEDOR",
  "GESTIÓN DE SALIDA"
);

$ctentcolumns = array();

foreach ($ctinerclumns as $estado) {
	$ctentcolumns[$estado] = array();
}

// Recorrer los resultados de la consulta y asignar cada tarea a la columna correspondiente
if ($listcards->num_rows > 0) {
  while ($row = $listcards->fetch_assoc()) {
    $ctentcolumns[$row["wstage"]][] = $row;
  }
}

$listkban = null;
$nberclum = 1;
$count = 0;
$totalsoles = 0;
foreach ($ctentcolumns as $estado => $tasks) {
    foreach ($tasks as $task) { 
      if($estado == "GESTIÓN DE INTERNAMIENTO"){
        $count += 1;
        $totalsoles += $task["wpriceproduct"];
      }
      if($estado == "GESTIÓN DE ENVÍO: PROVEEDOR"){
        $count += 1;
        $totalsoles += $task["wpriceproduct"];
      }
      if($estado == "GESTIÓN DE RETORNO: PROVEEDOR"){
        $count += 1;
        $totalsoles += $task["wpriceproduct"];
      } 
      if($estado == "GESTIÓN DE SALIDA"){
        $count += 1;
        $totalsoles += $task["wpriceproduct"];
      }
    }
    
    
  $cloretdo = "";
  if($estado == "GESTIÓN DE INTERNAMIENTO"){
    $cloretdo = "#ff3000";
    
  }
  if($estado == "GESTIÓN DE ENVÍO: PROVEEDOR"){
    $cloretdo = "#0C2A98";
  }
  if($estado == "GESTIÓN DE RETORNO: PROVEEDOR"){
    $cloretdo = "#0C2A98";
  } 
  if($estado == "GESTIÓN DE SALIDA"){
    $cloretdo = "#5AAC00";
  }
	$listkban .= '
	            <div class="dns_clumnkban">
	            	<h6 class="text-truncate" style="background-color: '.$cloretdo.';">' . $estado . '</h6>
	            	<div class="d-flex justify-content-around"><span>Cantidad: '.$count.'</span><span >Total S/'.number_format($totalsoles, 2) .'</span></div>
	            	<div class="dns_ctinerclumn" id="' . $estado . '">
	            	';
    $count = 0;
    $totalsoles = 0;
    // Imprimir la lista de tareas
    foreach ($tasks as $task) { 
      
      $fecha_actual = new DateTime();
      $colorstate = 'style="border:1px dashed #7db047;"';
      $fecha_inicio_obj = new DateTime($task["wentrydate"]);
      $fecha_actual = new DateTime();
      $diferencia = $fecha_inicio_obj->diff($fecha_actual)->days;
      if ($diferencia > 9 && $diferencia <= 20) {
        $colorstate = 'style="border:1px dashed #f0ce00;"';
      }
      if ($diferencia > 20) {
        $colorstate = 'style="border:1px dashed #ff1753;"';
      }
      $wstate = $task["wstate"];
      if ($task["wstate"] == "") {
        $wstate = 'AÚN SIN ESTADO';
      }
      $listkban .= '
            <div class="dns_cardkban" id="'.$task['wguidenumber'].'" '.$colorstate.'>
              <div id="idtask" style="display:none;">'.$task["wguidenumber"].'</div>
              <div class="dns_infotask">'.$task["wendpoint"].'-'.str_pad($task["wguidenumber"], 8, '0', STR_PAD_LEFT).'</div>
              <span>Estado</span>
              <div class="dns_infotask text-primary" >'.$wstate.'</div>
              <span>Responsable</span>
              <div class="dns_infotask">'.strip_tags(mb_substr($task["urazon"], 0,50)).'</div>

              <span>Cliente</span>
              <div class="dns_infotask">'.strip_tags(mb_substr($task["crazon"], 0,50)).'</div>

              <span>Producto</span>
              <div class="dns_infotask">'.strip_tags(mb_substr($task["descripcion"], 0,50)).'</div>

              <span>Fecha de Internamiento</span>
              <div class="dns_infotask">'.strip_tags(mb_substr($task["wentrydate"], 0,50)).'</div>
            </div>';

    }
    
    $listkban .= '
    				</div>
    			</div>';
    $nberclum++;
}
 
$Validate_Privileges->setCodUser($userinfo["ucoduser"]);
$checkvp = $Validate_Privileges->validate_privileges_in_warranty();
if($checkvp && $checkvp->num_rows == 1){
  echo '
  <div class="dns_boxkban">
    <button id="btndashboardwarranty" class="dns_buttondetails">Dashboard</button>
    <button id="button_openmodalinsert" class="dns_buttoncreate">CREAR</button>
    <input id="sarchtask" class="dns_sarchtask" type="text" name="cdna_bcdor" value="" placeholder="Busca aquí" required>
  </div>
  <div id="containerwarrantycards" class="dns_ctinerknban" >
    <div id="dns_arrowleftkban" class="dns_arrowleftkban"><i class="bx bxs-chevrons-left"></i></div>
    <div id="dns_boardkban" class="dns_boardkban">
      '.$listkban.'
      <!-- Aqui termina la lista de tarjetas -->
    </div>
    <div class="dns_arrowrightkban" id="dns_arrowrightkban"><i class="bx bxs-chevrons-right"></i></div>
  </div>

  <!-- Ventana derecha clientes para registrar -->
  <div id="containermodalrazon" class="dns_containermodalright dns_zi3">
    <button id="button_closemodalrazon" class="dns_closemodalright">Cerrar</button>
    <div class="dns_headermodalright p-3">
      <h2>Modulo Cliente</h2>
    </div>
    <div class="dns_bodymodalright px-3 m-0">
      <div class="dns_bodycontainer position-relative p-3">
        <div class="row">
          <div id="container_formrazon" class="col-lg-8">
            <div>
              <button id="register_companies" class="dns_buttondeafult">Registro para Empresas</button>
              <h6 class="pt-2 ">Información del Cliente</h6>
              <div class="dns_formgroup">
                <div class="row">
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                    <label class="dns_formlbl">Documento de Identidad<span class="text-danger">*</span></label>
                    <div id="loadbgloading" class="dns_groupbi">
                      <button id="searchrazon" class="dns_gb">Buscar</button>
                      <input type="text" class="dns_gi" id="cdni" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                    <label class="dns_formlbl">Primer nombre<span class="text-danger">*</span></label>
                    <input type="text" class="dns_forminput" id="cnombre1" autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                    <label class="dns_formlbl">Segundo nombre</label>
                    <input type="text" class="dns_forminput" id="cnombre2" autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                    <label class="dns_formlbl">Apellido Paterno<span class="text-danger">*</span></label>
                    <input type="text" class="dns_forminput" id="cpaterno" autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                    <label class="dns_formlbl">Apellido Materno<span class="text-danger">*</span></label>
                    <input type="text" class="dns_forminput" id="cmaterno" autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                    <label class="dns_formlbl">Dirección</label>
                    <input type="text" class="dns_forminput" id="cdireccion" autocomplete="off">
                  </div>                
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                    <label class="dns_formlbl">Número Telefónico<span class="text-danger">*</span></label>
                    <input type="tel" class="dns_forminput" id="ctelefono1" autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                    <label class="dns_formlbl">Número Adicional</label>
                    <input type="tel" class="dns_forminput" id="ctelefono2" autocomplete="off">
                  </div>
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                    <label class="dns_formlbl">Correo Electrónico</label>
                    <input type="email" class="dns_forminput" id="ccorreo" autocomplete="off">
                  </div>
                </div>
              </div>
              <button id="saveclient" class="dns_buttonsave">Registrar</button>
            </div> 
          </div>
          <div class="col-lg-4">
            <p class="dns_df-jc-jaic fw-bold w-100 h-100 ">Por favor rellena los datos completos, esto te sirve a ti y a la empresa para poder encontrar rapidamente a los clientes.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Ventana derecha clientes para ver la información -->

  <!-- Ventana derecha para ver la información -->
  <div id="containermodalcarddetails" class="dns_containermodalright dns_zi2">
    <button id="button_closemodaldetails" class="dns_closemodalright">Cerrar</button>
    <div class="dns_headermodalright position-relative p-3">
      <h2 id="dwepwgn">Información de Internamiento</h2>
      <a class="dnsbuttoneyelash" id="print_w" href="" target="_blank">Imprimir</a>
    </div>

    <div class="dns_bodymodalright px-3 m-0 pb-3">

      <div class="dns_bodycontainer position-relative p-3">
        <div class="row">
          <div id="container_formrazon" class="col-lg-8">
            <div>
              <h6 class="pt-2 ">Estado</h6>
              <div class="dns_formgroup">
                <div class="row">
                  <div class="col-12 col-md-12 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Selecciona un Estado por favor.</span>
                    <select id="dstates" class="dns_forminput"> </select>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <h6 class="pt-2 ">Información del Cliente</h6>
              <div class="dns_formgroup">
                <div class="row">
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Documento de Identidad</span>
                    <span id="dccodcli" class="dns_dcc1"></span>
                  </div>
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Razón</span>
                    <span id="dcrazon" class="dns_dcc1"></span>
                  </div>
                   <div class="col-12 col-md-6 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Teléfono Principal</span>
                    <span id="dctelefono1" class="dns_dcc1"></span>
                  </div>
                   <div class="col-12 col-md-6 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Teléfono Adicional</span>
                    <span id="dctelefono2" class="dns_dcc1"></span>
                  </div>
                   <div class="col-12 col-md-6 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Razón</span>
                    <span id="dcdireccion" class="dns_dcc1"></span>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <h6 class="pt-2 ">Información del Producto</h6>
              <div class="dns_formgroup">
                <div class="row">
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Código</span>
                    <span id="dcodigo" class="dns_dcc1"></span>
                  </div>
                  <div class="col-12 col-md-6 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Descripción</span>
                    <span id="ddescripcion" class="dns_dcc1"></span>
                  </div>
                   <div class="col-12 col-md-6 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Número de Serie</span>
                    <span id="dserialnumber" class="dns_dcc1"></span>
                  </div>
                   <div class="col-12 col-md-6 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Valor</span>
                    <span id="dwpriceproduct" class="dns_dcc1"></span>
                  </div>
                   <div class="col-12 col-md-6 col-lg-6 dns_formcontainer pb-2">
                    <span class="dns_st1">Comprobante</span>
                    <span id="dwvoucher" class="dns_dcc1"></span>
                  </div>

                </div>
              </div>
            </div> 

            <div>
              <div class="col-lg-12">
                <h6 class="pt-2">Información del Servicio</h6>
                <div class="dns_formgroup">
                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-8 dns_formcontainer">
                      <label class="dns_formlbl">Accesorios<span class="text-danger">*</span></label>
                      <input type="text" class="dns_forminput" id="dwaccessories" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                      <label class="dns_formlbl">Problema reportado<span class="text-danger">*</span></label>
                      <input type="text" class="dns_forminput" id="dwprpc" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                      <label class="dns_formlbl">Observaciones del equipo<span class="text-danger">*</span></label>
                      <input type="text" class="dns_forminput" id="dwequipmentstatus" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                      <label class="dns_formlbl">Trabajo a realizar<span class="text-danger">*</span></label>
                      <input type="text" class="dns_forminput" id="dwdiagnostic" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                      <label class="dns_formlbl">Problemas detectados</label>
                      <input type="text" class="dns_forminput" id="dwproblemsdetected" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                      <label class="dns_formlbl">Observaciones finales</label>
                      <input type="text" class="dns_forminput" id="dwconcludingremarks" autocomplete="off">
                    </div>
                    <div class="col dns_formcontainer align-items-center p-3">
                      <button id="update_services_w" class="dns_buttonsave btntstn1">Actualizar</button>
                    </div>

                  </div>
                </div>
              </div>
            </div>


          </div>
          <div class="col-lg-4">
              <h6 class="pt-2 ">Linea de Tiempo</h6>
              <div id="container_timeline"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Ventana derecha para ver la información -->

<!-- Ventana derecha para crear nueva tarea -->
  <div id="containermodalinsert" class="dns_containermodalright dns_zi2">
    <button id="button_closemodalinsert" class="dns_closemodalright">Cerrar</button>
    <div class="dns_headermodalright p-3">
      <h2>Registrar Garantía</h2>
    </div>
    <div class="dns_bodymodalright px-3">
      <div class="dns_bodycontainer p-3">
        <div class="row">
          <div class="col-lg-12">
            <h6 class="pt-2 ">Información del Cliente</h6>
            <div class="dns_formgroup">
              <div class="row">
                <div class="col-12 col-lg-6 dns_formcontainer">
                  <label class="dns_formlbl">Cliente <span class="text-danger">*</span></label>
                  <div class="dns_groupbi">
                    <button id="btn_openmodalrazon" class="dns_gb">Registrar Cliente</button>
                    <input type="text" class="dns_gi" id="ccodcli" name="dtrpsble" autocomplete="off">
                    <div id="searchlistclient" class="dns_container_searchlist">
                      <div id="listclient" class="dns_list"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-lg-6 dns_formcontainer">
                  <div id="validateclient"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <h6 class="pt-2">Información Financiera</h6>
            <div class="dns_formgroup">
              <div class="row">
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Comprobante</label>
                  <input type="text" class="dns_forminput" id="wvaucher" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Precio del Producto</label>
                  <input type="text" class="dns_forminput" id="wpriceproduct" autocomplete="off">
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <h6 class="pt-2">Información del Producto</h6>
            <div class="dns_formgroup">
              <div class="row">
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <div class="position-relative w-100">
                    <label class="dns_formlbl">Código <span class="text-danger">*</span></label>
                    <input type="text" class="dns_forminput" id="codigo" autocomplete="off">
                    <div id="searchlistcodigo" class="dns_container_searchlist">
                      <div id="listcodigo" class="dns_list"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-8 dns_formcontainer">
                  <div class="position-relative w-100">
                    <label class="dns_formlbl">Descripción<span class="text-danger">*</span></label>
                    <input type="text" class="dns_forminput" id="descripcion" autocomplete="off">
                    <div id="searchlistdescripcion" class="dns_container_searchlist">
                      <div id="listdescripcion" class="dns_list"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Categoría<span class="text-danger">*</span></label>
                  <input type="text" class="dns_forminput" id="categoria" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">SubCategoría<span class="text-danger">*</span></label>
                  <input type="text" class="dns_forminput" id="subcategoria" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Marca<span class="text-danger">*</span></label>
                  <input type="text" class="dns_forminput" id="marca" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-8 dns_formcontainer">
                  <label class="dns_formlbl">Accesorios<span class="text-danger">*</span></label>
                  <input type="text" class="dns_forminput" id="waccessories" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Número de Serie<span class="text-danger">*</span></label>
                  <input type="text" class="dns_forminput" id="serialnumber" autocomplete="off">
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <h6 class="pt-2">Información del Servicio</h6>
            <div class="dns_formgroup">
              <div class="row">
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Problema reportado<span class="text-danger">*</span></label>
                  <input type="text" class="dns_forminput" id="wprpc" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Observaciones del equipo<span class="text-danger">*</span></label>
                  <input type="text" class="dns_forminput" id="wequipmentstatus" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Trabajo a realizar<span class="text-danger">*</span></label>
                  <input type="text" class="dns_forminput" id="wdiagnostic" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Problemas detectados</label>
                  <input type="text" class="dns_forminput" id="wproblemsdetected" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Observaciones finales</label>
                  <input type="text" class="dns_forminput" id="wconcludingremarks" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-4 dns_formcontainer">
                  <label class="dns_formlbl">Fecha Estimada <span class="text-danger">*</span></label>
                  <input type="datetime-local" class="dns_forminput" id="dtfchalmte" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div>

    <div class="dns_foodermodal">
          <button id="insert_w" class="dns_buttonsave btntstn1">Guardar</button>
          <button id="close_w" class="dns_buttonclose btntstn1">Cerrar</button>
    </div>
  </div>
<!-- Ventana derecha para crear nueva tarea -->
  <script type="text/javascript" src="modules//warranty/js/warrantyv1.js"></script>
  ';
}else{
  echo '<div class="text-danger">No tienes los privilegios suficientes para acceder a esta Zona.</div>';
}

?>

<!-- <script src="assets/js/ChartLine_warrantyindicator1.js"></script> -->

