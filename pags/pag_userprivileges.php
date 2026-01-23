<?php

if(!defined("pag_userprivileges"))
{
    header("Location: /index.php");
    exit();
}

include "csses/userprivileges/userprivileges.php";

$Add_Privileges = new Add_Privileges();
$tolist = $Add_Privileges->tolist_UserPrivilege();
$table_userprivileges = '';

$table_userprivileges .= '
                      <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th scope="col">Colaborador</th>
                              <th scope="col">Plataforma y Modulo</th>
                            </tr>
                          </thead>
                          <tbody>
                      ';
foreach ($tolist as $key) {
  $table_userprivileges .= '
                        <tr>
                          <td><div>'.$key['area'].'</div><div>'.$key['unombre1'].' '.$key['upaterno'].'</div></td>
                          <td><div>'.$key['gup'].'</div><div>'.$key['tpe'].'</div></td>
                          <td><button id="deleteprivilege" class="dns_deleteprivilege" data-platform="'.$key['gup'].'" data-mdle="'.$key['tpe'].'" data-ucoduser="'.$key['ucoduser'].'"><i class="bx bxs-trash"></i></button></td>
                        </tr>';
}
$table_userprivileges .= '
                        </tbody>
                      </table>
                      ';

$Validate_Privileges = NEW Validate_Privileges();
$Validate_Privileges->setCodUser($userinfo["ucoduser"]);
$checkvp = $Validate_Privileges->validate_privileges_in_userprivileges();
if($checkvp && $checkvp->num_rows == 1){
  echo '
    <div class="dns_containerform">

  <!-- Buscar usuario -->
  <div class="dns_content_input">

    <label class="dns_label">Buscar Usuario</label>

    <div class="dns_ctndordtrpsble">
      <input
        type="text"
        class="dns_input"
        id="dtrpsble"
        name="dtrpsble"
        autocomplete="off"
        placeholder="Nombre o DNI"
      >

      <div id="dtcdgorpsble"></div>

      <div id="dtctndorltarpsble" class="dns_dtctndorltarpsble">
        <div id="ltarpsble" class="dns_ltarpsble"></div>
      </div>
    </div>

  </div>

  <!-- Plataforma -->
  <div class="dns_content_input">
    <label class="dns_label">Plataforma</label>

    <select id="groupplatform" class="dns_input">
      <option value="">Selecciona la Plataforma</option>
      <option value="gestorintegral">Gestor Integral</option>
      <option value="backofficeweb">Página Web</option>
      <option value="soportetecnico">Soporte Técnico</option>
    </select>
  </div>

</div>


<!-- FILA 2 -->
<div class="dns_containerform">

  <!-- Modulo -->
  <div class="dns_content_input">
    <label class="dns_label">Módulo</label>

    <select id="listgroupplatform" class="dns_input">
      <option value="">Selecciona un módulo</option>
    </select>
  </div>

  <!-- Botón -->
  <div class="dns_content_input">
    <label class="dns_label">&nbsp;</label>

    <button id="send_form_userprivileges" class="dns_btnform">
      Dar Permiso
    </button>
  </div>

</div>


<!-- TABLA -->
<div id="tolisttable" class="col-12">
  '.$table_userprivileges.'
</div>

  ';
}else{
  echo '

  <div class="text-danger">No tienes los privilegios suficientes para acceder a Los Privilegios de Usuario.</div>';
}

?>

<script>
$(document).ready(function(){
    $('#groupplatform').change(function(){
        var groupplatform = $(this).val();
        $.ajax({
            url: 'ajaxjs/userprivileges/loadoptions.php',
            type: 'post',
            data: {groupplatform: groupplatform},
            dataType: 'json',
            success:function(response){
                var len = response.length;
                $("#listgroupplatform").empty();
                for( var i = 0; i<len; i++){
                    var value = response[i]['value'];
                    var text = response[i]['text'];
                    $("#listgroupplatform").append("<option value='"+value+"'>"+text+"</option>");
                }
            }
        });
    });
    $('#send_form_userprivileges').on('click', function(){
      //dtcdeuser
      var groupplatform = $('#groupplatform').val();
      var listgroupplatform = $('#listgroupplatform').val();
        $.ajax({
            url: 'ajaxjs/userprivileges/saveprivileges.php',
            type: 'post',
            data: {dtcdeuser: dtcdeuser, groupplatform: groupplatform, listgroupplatform: listgroupplatform},
            dataType: 'json',
            success:function(response){
              alert(response.data);
              $('#tolisttable').html(response.html);
            },
            error: function(error){
              console.log(error);
            } 
        });
      
    });

    $('#tolisttable').on('click', '.dns_deleteprivilege', function(){ 
        $.ajax({
            url: 'ajaxjs/userprivileges/deleteprivileges.php',
            type: 'POST',
            data: { platform: $(this).data('platform'), mdle: $(this).data('mdle'), ucoduser: $(this).data('ucoduser') },
            dataType: 'json',
            success: function(response) {
                alert(response.data);
                $('#tolisttable').html(response.html);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});
</script>
