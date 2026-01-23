<?php

if(!defined("pag_taskmnger"))
{
    header("Location: /index.php");
    exit();
}

include "csses/task/kbantask.php";


$kbantask = new kbantask();

if(!empty($_SESSION['ucoduser'])){ $coduser = $_SESSION['ucoduser']; }
if($user->getSession()===FALSE) { header("location:lgn.php"); }
if(isset($_GET['q'])) { $user->logout(); header("location:lgn.php"); }

$csvar_cdna_bcdor = null;

$kbantask->setCodUser($coduser);
$listcards = $kbantask->GetListGrtas();

$ctinerclumns = array(
  "En Progreso",
  "Pendientes de Revisar",
  "Completado"
);

$ctentcolumns = array();

foreach ($ctinerclumns as $estado) {
	$ctentcolumns[$estado] = array();
}

// Recorrer los resultados de la consulta y asignar cada tarea a la columna correspondiente
if ($listcards->num_rows > 0) {
  while ($row = $listcards->fetch_assoc()) {
    $ctentcolumns[$row["etdo"]][] = $row;
  }
}

$listkban = null;
$nberclum = 1;
$count = 0;
foreach ($ctentcolumns as $estado => $tasks) {
  $cloretdo = "";
  if($estado == "En Progreso"){
    $cloretdo = "#ff3000";
  }
  if($estado == "Pendientes de Revisar"){
    $cloretdo = "#0C2A98";
  }
  if($estado == "Completado"){
    $cloretdo = "#5AAC00";
  }
	$listkban .= '
	            <div class="dns_clumnkban">
	            	<h6 class="text-truncate" style="background-color: '.$cloretdo.';">' . $estado . '</h6>
	            	<div class="dns_ctinerclumn" id="' . $estado . '">
	            	<div class="dns_nberclumn">'.$nberclum.'</div>';
    
    // Imprimir la lista de tareas
    foreach ($tasks as $task) {
      $cloretdofchalmte ="";
      if($task["etdofchalmte"] == "A Tiempo"){
        $cloretdofchalmte = "#5AAC00";
      }
      if($task["etdofchalmte"] == "Atrasado"){
        $cloretdofchalmte = "#DE013B";
      } 

        $listkban .= '
              <div class="dns_cardkban" style="border-bottom: 1px groove '.$cloretdofchalmte.';" id="'.$task['nmroid'].'">
                <span>Descripción</span>
                <div class="dns_infotask">'.strip_tags(mb_substr($task["dccon"], 0,50)).'</div>
                <div id="idtask" style="display:none;">'.$task["nmroid"].'</div>
                <div class="dns_infotask" style="display:none;">Tarea-'.str_pad($task["nmroid"], 8, '0', STR_PAD_LEFT).'</div>
                <span>Creador</span>
                <div class="text-truncate dns_infotask">'.$task["cunombre1"].' '.$task["cupaterno"].'</div>
                <span>Responsable</span>
                <div class="text-truncate dns_infotask">'.$task["runombre1"].' '.$task["rupaterno"].'</div>
                <span>Fecha de internamiento</span>
                <div class="dns_infotask">'.$task["fchareg"].'</div>
                <span>Fecha Límite</span>
                <div class="dns_infotask">'.$task["fchalmte"].'</div>
                <span>Nivel de Entrega</span>
                <div id="lveldlvry" class="dns_infotask">'. $task["nvel"].'</div>
                <span>Estado Fecha Límite</span>
                <div id="deadline" class="dns_infotask" style="color:'.$cloretdofchalmte.';">'. $task["etdofchalmte"].'</div>
              </div>';

    }
    
    $listkban .= '
    				</div>
    			</div>';
    $nberclum++;   
}

$Validate_Privileges->setCodUser($userinfo["ucoduser"]);
$checkvp = $Validate_Privileges->validate_privileges_in_tasks();
if($checkvp && $checkvp->num_rows == 1){
  echo '
  <div class="dns_boxkban">
    <button id="btnpgeefcecy" class="dns_btnpgeefcecy">Eficiencia</button>
    <button class="dns_btnnewrgter">CREAR</button>
    <input id="sarchtask" class="dns_sarchtask" type="text" name="cdna_bcdor" value="" placeholder="Busca tareas aquí" required>
  </div>
  <div id="dns-ctndor-knbn" class="dns_ctinerknban" >
    <div id="dns_arrowleftkban" class="dns_arrowleftkban"><i class="bx bxs-chevrons-left"></i></div>
    <div id="dns_boardkban" class="dns_boardkban">
      '.$listkban.'
    <!-- Aqui termina la lista de tarjetas -->
    </div>
    <div class="dns_arrowrightkban" id="dns_arrowrightkban"><i class="bx bxs-chevrons-right"></i></div>
  </div>
  <!-- fondo para los modals -->
  <div id="bgundmdal" class="dns_bgundmdal"></div>

  <!-- Ventana derecha para ver la información -->
  <div id="mdal_dtilstask" class="dns_ctnermdalr">
    <button id="csedtilstask" class="dns_csemdalr">Cerrar</button>
    <div class="dns_hadermdalr">
      <h4 id="dttttlo" class="text-truncate"></h4><span><?php  ?></span>
    </div>
    <div class="dns_bodymdalr">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="ctndrifodtosga">
            <h4>Tarea #<span id="dttnmroid"></span></h4>
            <div class="ctndornp">
              <div id="dttdccon"></div>
            </div>
            <h4>Comentarios</h4>
            <div id="dttcmtros" class="dns_ltacmtros"></div>
            <div class="dns_containerform">
              <div class="dns_content_input">
                <div id="ctndoraddcomments"  class="py-1">
                  <div id="addcomments" style="display: none;">
                      <div class="dns_content_input">
                        <textarea id="dtcmtros" class="dns_input" rows="2" cols="50" autocomplete="off"></textarea>
                      </div>
                      <div class="dns_content_input">
                        <button id="evarcmtro" class="dns_btnsave">Enviar</button> 
                        <button id="hidden_addcomments" class="dns_btnclose">Cancelar</button>
                        <label id="mensaje"></label>
                      </div>
                  </div>
                  <button id="show_addcomments"  class="dns_input" autocomplete="off">Agregar Comentario</button>
                </div>
                <div id="ctndoraddfiletocomments" class="py-1">
                  <div id="addfiletocomments" class="dns_taskuploadfiletocomments position-relative overflow-hidden" style="display: none;">
                    <div class="dns_ctneruploadfile">
                      <input type="file" id="filetocomments" style="display: none;" accept=".doc, .docx, .pdf, .xlsx, .xls">
                      <button id="btnuploadfiletocomments" class="dns_btnuploadfile">
                        <i class="bx bx-upload"></i>
                        <span>Cargar</span>
                      </button>
                    </div>
                    <div id="ctnerfilestocomments" class="dns_ctnerfiles">
                    </div>
                  </div>
                  <button id="show_addfiletocomments"  class="dns_input" autocomplete="off">Agregar Documento</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-lg-4 " style="height: 100vh;">
          <div class="ctndrifodtosga">
            <div class="ctndornp my-2 p-2">
              <label>Creado por</label>
              <div id="dtucador"></div>
            </div>
            <div class="ctndornp my-2 p-2">
              <label>Responsable</label>
              <div id="dturpsble"></div>
            </div>
            <div class="ctndornp my-2 p-2">
              <label>Creado el:</label>
              <div id="dttfchareg"></div>
              <label>Fecha Límite:</label>
              <div class="dns_containerform">
                <div class="dns_content_input"><input type="datetime-local" class="dns_input" id="dttfchalmte" autocomplete="off">
                </div>
              </div>
              <!-- <div id="dttfchalmte"></div> -->
              <label>Estado Fecha Limite:</label>
              <div id="dttetdofchalmte"></div>
              <label>Estado:</label>
              <div id="dttetdo"></div>
              <label>Nivel de Entrega:</label>
              <div id="dttnvel"></div>
            </div>
          </div>
          <div id="dtlneatepo" class="my-2" style="max-height: 50%; overflow: auto;"></div>
        </div>
      </div>
      <div style="height:150px; widht:100%;"></div>
    </div>
  </div>
<!-- Ventana derecha para ver la información -->

<!-- Ventana derecha para crear nueva tarea -->
  <div id="containermodalnewtask" class="dns_ctnermdalr">
    <button id="csenewrgterstask" class="dns_csemdalr">Cerrar</button>
    <div class="dns_hadermdalr">
      <h2>Nueva Tarea</h2>
    </div>
    <div class="dns_bodymdalr">
      <div class="dns_bodyctndor">
        <div class="row">
          <div class="col-12">
            <input type="hidden" id="dtcadorid" value="">
            <div class="dns_ctnerform">
                <input type="text" class="dns_dtnbretra" id="dtnbretra" name="dtnbretra" autocomplete="off" placeholder="Introduzca el nombre de la tarea">
                <label id="msj_dtnbretra"></label>
            </div>
            <div class="dns_ctnerform">
                <!-- <textarea class="dns_dtdccon" rows="5" cols="33" id="" name="dtdccon" placeholder="Introduzca la descripción de la tarea"></textarea> -->
                <textarea id="dtdccon" class="dns_dtdccon" name="contenido"></textarea>
                <label id="msj_dtdccon"></label>
            </div>
            <div class="dns_taskuploadfile position-relative overflow-hidden">
              <div class="dns_ctneruploadfile">
                <input type="file" id="file" style="display: none;" accept=".doc, .docx, .pdf, .xlsx, .xls">
                <button id="btnuploadfile" class="dns_btnuploadfile">
                  <i class="bx bx-upload"></i>
                  <span>Cargar</span>
                </button>
              </div>
              <div id="ctnerfiles" class="dns_ctnerfiles">

              </div>
            </div>
            <div class="dns_taskotons">
              <div class="row">
                <div class="col-12 col-lg-6 dns_ctnerform">
                  <label>Responsable</label>
                  <input type="text" class="dns_dtrpsble" id="dtrpsble" name="dtrpsble" autocomplete="off">
                  <label id="msj_dtrpsble"></label>
                  <div id="dtcdgorpsble"></div>
                  <div id="dtctndorltarpsble" class="dns_dtctndorltarpsble ">
                    <div id="ltarpsble" class="dns_ltarpsble">
                    </div>
                  </div>
                  <label id="msj_dtdni"></label>
                </div>
                <div class="col-12 col-lg-3 dns_ctnerform">
                  <label>Fecha Estimada</label>
                  <input type="datetime-local" class="" id="dtfchalmte" autocomplete="off">
                  <label id="msj_dtfchalmte"></label>
                </div>
                <div class="col-12 col-lg-3 dns_ctnerform">
                  <label>Eficiencia</label>
                  <select id="dtlvelefcecy">
                  <option value="Bajo">Bajo - 10 de eficiencia</option>
                  <option value="Medio" selected>Medio - 20 de eficiencia</option>
                  <option value="Alto">Alto - 30 de eficiencia</option>
                   <option value="Crítico">Crítico - 50 de eficiencia</option>
                  </select>
                  <label id="msj_dtlvelefcecy"></label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div style="height:150px; width:100%;"></div>
    </div>
    <div class="dns_fdermdal">
          <button id="btn_gadargarccon" class="dns_btnsvetask">Guardar</button>
          <button id="btn_crrarrgarccon" class="dns_btncsemdal">Cerrar</button>
    </div>
  </div>
<!-- Ventana derecha para crear nueva tarea -->
  <script type="text/javascript" src="assets/js/tasksv1.js"></script>
  ';
}else{
  echo '<div class="text-danger">No tienes los privilegios suficientes para acceder a esta Zona.</div>';
}

?>


