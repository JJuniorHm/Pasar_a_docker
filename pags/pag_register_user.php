<?php

if (!defined("pag_register_user"))
{
  header("location: /index.php");
  exit();
}

$Validate_Privileges= new Validate_Privileges();
$Validate_Privileges->setCodUser($userinfo["ucoduser"]);

$checkvp = $Validate_Privileges->validate_privileges_in_userprivileges(pag_register_user);

if (!$checkvp || $checkvp ->num_rows !==1){
  echo'<div class ="text-danger">
  No tienes los privilegios suficientes para acceder al registro de usuarios
  </div>';
  
  exit;
}

?>
<div class ="dns-auth">
  <div class="card">
    <div class="card-header">
      <h5>Formulario de Registro de Usuarios</h5>
    </div>

    <div class="card-body">
      <form id="frmRegisterUser">

        <!-- CÓDIGO DE USUARIO (MANUAL) -->
        <div class="mb-3">
          <label>Código de Usuario</label>
          <input
            type="text"
            class="form-control"
            name="ucoduser"
            maxlength="4"
            pattern="\d{4}"
            required
            placeholder="Ingrese 4 dígitos"
          >
        </div>

        <!-- PASSWORD (AUTOMÁTICO Y BLOQUEADO) -->
        <div class="mb-3">
          <label>Contraseña</label>
          <div class="input-group">
            <input
              type="text"
              class="form-control"
              name="upassword"
              id="upassword"
              readonly
            >
            <button type="button" class="btn btn-secondary" id="genPass">
              Generar
            </button>
          </div>
        </div>

        <!-- DOCUMENTO -->
        <div class="row mb-3">
          <div class="col-md-4">
            <label>Tipo Documento</label>
            <select class="form-select" name="utypedoc">
              <option value="DNI">DNI</option>
              <option value="CE">Carnet de Extranjería</option>
            </select>
          </div>
          <div class="col-md-8">
            <label>N° Documento</label>
            <input type="text" class="form-control" name="udni" required>
          </div>
        </div>

        <!-- NOMBRES -->
        <div class="row mb-3">
          <div class="col-md-4">
            <label>Apellido Paterno</label>
            <input type="text" class="form-control" name="upaterno" required>
          </div>
          <div class="col-md-4">
            <label>Apellido Materno</label>
            <input type="text" class="form-control" name="umaterno" required>
          </div>
          <div class="col-md-4">
            <label>Primer Nombre</label>
            <input type="text" class="form-control" name="unombre1" required>
          </div>
        </div>

        <div class="mb-3">
          <label>Segundo Nombre</label>
          <input type="text" class="form-control" name="unombre2">
        </div>

        <!-- NOMBRE COMPLETO AUTO -->
        <div class="mb-3">
          <label>Nombre Completo</label>
          <input
            type="text"
            class="form-control"
            name="unombrecompleto"
            readonly
          >
        </div>

        <!-- GÉNERO / FECHA -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Género</label>
            <select class="form-select" name="ugenero">
              <option value="">Seleccione</option>
              <option value="M">Masculino</option>
              <option value="F">Femenino</option>
              <option value="O">Otro</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Fecha de Nacimiento</label>
            <input type="date" class="form-control" name="ufenac">
          </div>
        </div>

        <!-- TELÉFONOS -->
        <div id="phonesContainer">
          <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" class="form-control" name="utelefono[]" required>
          </div>
        </div>

        <button type="button" class="btn btn-outline-secondary mb-3" id="btnAddPhone">
          + Agregar otro número
        </button>

        <br>
        <div class= "text-end" >
          <button type="submit" class="btn btn-primary" style="background:#28a745;color:#fff;">
          Registrar Usuario
          </button>
        </div>
      </form>
    </div>
  </div>
</div>