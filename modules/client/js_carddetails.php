<?php

//apis-token-8583.OytA6guoLJr5AnV0KH9QJmGV6xIRdPE1

if ($_SERVER["REQUEST_METHOD"] == "POST") {

include "class_insertclient.php";

$class_insert = new class_insertClient();

    $clientshtml = '
        <div class="col">
            <button id="register_companies" class="dns_buttondeafult">Registro para Empresas</button>
            <h6 class="pt-2 ">Información de Cliente</h6>
            <div class="dns_formgroup">
              <div class="row">
                <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                    <label class="dns_formlbl">Documento de Identidad<span class="text-danger">*</span></label>
                    <div id="loadbgloading" class="dns_groupbi">
                      <button id="searchrazon" class="dns_gb">Buscar</button>
                      <input type="text" class="dns_gi" id="cdni" value="'.( !empty($_POST['ccodcli']) ? $_POST['ccodcli'] : '' ).'" autocomplete="off">
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
                  <input type="text" class="dns_forminput" id="ctelefono1" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                  <label class="dns_formlbl">Número Adicional</label>
                  <input type="text" class="dns_forminput" id="ctelefono2" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                  <label class="dns_formlbl">Correo Electrónico</label>
                  <input type="email" class="dns_forminput" id="ccorreo" autocomplete="off">
                </div>
              </div>
            </div>
            <button id="saveclient" class="dns_buttonsave">Registrar</button>
        </div>
    ';

    $companieshtml = '
        <div class="col">
            <button id="register_client" class="dns_buttondeafult">Registro para Clientes</button>
            <h6 class="pt-2 ">Información de Empresa</h6>
            <div class="dns_formgroup">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                        <label class="dns_formlbl">RUC<span class="text-danger">*</span></label>
                        <div id="loadbgloading" class="dns_groupbi">
                          <button id="searchruc" class="dns_gb">Buscar</button>
                          <input type="text" class="dns_gi" id="cruc" value="'.( !empty($_POST['ccodcli']) ? $_POST['ccodcli'] : '' ).'" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                      <label class="dns_formlbl">Razón Social<span class="text-danger">*</span></label>
                      <input type="text" class="dns_forminput" id="crazon" autocomplete="off">
                    </div> 
                    <div class="col-12 dns_formcontainer">
                      <label class="dns_formlbl">Dirección<span class="text-danger">*</span></label>
                      <input type="text" class="dns_forminput" id="cdireccion" autocomplete="off">
                    </div>  
                </div>
            </div>
        </div>
        <div class="col">
            <h6 class="pt-2 ">Información de Contacto</h6>
            <div class="dns_formgroup">
              <div class="row">
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
                  <label class="dns_formlbl">Número Telefónico<span class="text-danger">*</span></label>
                  <input type="text" class="dns_forminput" id="ctelefono1" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                  <label class="dns_formlbl">Número Adicional</label>
                  <input type="text" class="dns_forminput" id="ctelefono2" autocomplete="off">
                </div>
                <div class="col-12 col-md-6 col-lg-6 dns_formcontainer">
                  <label class="dns_formlbl">Correo Electrónico</label>
                  <input type="email" class="dns_forminput" id="ccorreo" autocomplete="off">
                </div>
              </div>
            </div>
            <button id="savecompanie" class="dns_buttonsave">Registrar</button>
        </div>
    ';

    //Validar solo letras
    function validateOnlyLetters($input) {
        return !empty(trim($input)) && preg_match('/^[a-zA-Z\s]+$/', $input);
    }
    function validateOnlyNumbers($input) {
        return !empty(trim($input)) && preg_match('/^[0-9]+$/', $input);
    }
    function validateEmail($email) {
        // Expresión regular para validar direcciones de correo electrónico
        return !empty(trim($email)) && filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validateinputs(){
        if($_POST['typeregister'] === 'savecompanie'){
            if(!validateOnlyNumbers($_POST['ccodcli'])){
                echo json_encode(array('status' => false, 'resulthtml' => 'En el campo "Razon Social" solo se permiten números.'));
                exit();
            }
        }
        if($_POST['typeregister'] === 'saveclient'){
            if(!validateOnlyNumbers($_POST['ccodcli'])){
                echo json_encode(array('status' => false, 'resulthtml' => 'En el campo "Documento de Identidad" solo se permiten números.'));
                exit();
            }
        }
        if( strlen($_POST['ccodcli']) < 8){
            echo json_encode(array('status' => false, 'resulthtml' => 'El campo Documento de Identidad debe tener 8 caracteres para "documentos nacionales" y más de 8 caracteres para "documentos de extranjeros".'));
            exit();
        }
        if(!validateOnlyLetters($_POST['cnombre1'])){
            echo json_encode(array('status' => false, 'resulthtml' => 'En el campo "Primer Nombre" solo se permiten Letras y no debe estar vacío.'));
            exit();
        }
        if(!empty($_POST['cnombre2'])){
            if(!validateOnlyLetters($_POST['cnombre2'])){
                echo json_encode(array('status' => false, 'resulthtml' => 'En el campo "Segundo Nombre" solo se permiten Letras.'));
                exit();
            }
        }
        if(!validateOnlyLetters($_POST['cpaterno'])){
            echo json_encode(array('status' => false, 'resulthtml' => 'En el campo "Apellido Paterno" solo se permiten Letras y no debe estar vacío.'));
            exit();
        }
        if(!validateOnlyLetters($_POST['cmaterno'])){
            echo json_encode(array('status' => false, 'resulthtml' => 'En el campo "Apellido Materno" solo se permiten Letras y no debe estar vacío.'));
            exit();
        }
        if (!empty(trim($_POST['cdireccion']))) {
            if (!preg_match('/^[a-zA-Z0-9\s.,#-]+$/', $_POST['cdireccion'])) {
                echo json_encode(array('status' => false, 'resulthtml' => 'En el campo "Dirección" solo se permiten algunos caracteres validos como "a-z", "A-Z", "0-9", "El punto->(.)", "La coma(,)"."Numeral(#)","El guión(-)"'));
                exit();
            }
        }
        if(!validateOnlyNumbers($_POST['ctelefono1'])){
            echo json_encode(array('status' => false, 'resulthtml' => 'En el campo "Número Telefónico" solo se permiten números y no debe estar vacío.'));
            exit();
        }
        if(!empty($_POST['ctelefono2'])){
            if(!validateOnlyNumbers($_POST['ctelefono2'])){
                echo json_encode(array('status' => false, 'resulthtml' => 'En el campo "Número Adicional" solo se permiten números.'));
            exit();
            }
        }
        if(!empty($_POST['ccorreo'])){
            if(!validateEmail($_POST['ccorreo'])){
                echo json_encode(array('status' => false, 'resulthtml' => 'En campo "Correo Electrónico" no tiene el formato correcto.'));
                exit();
            }
        }
    }

    if($_POST['typeregister'] === 'companies'){
        $arrayName = array( 'resulthtml' => $companieshtml );
        echo json_encode($arrayName);
        exit();
    }
    if($_POST['typeregister'] === 'clients'){
        $arrayName = array( 'resulthtml' => $clientshtml );
        echo json_encode($arrayName);
        exit();
    }
    if($_POST['typeregister'] === 'saveclient'){
        validateinputs();
        $crazon = trim($_POST['cpaterno']).' '.trim($_POST['cmaterno']).' '.trim($_POST['cnombre1']).' '.trim($_POST['cnombre2']);
        $class_insert->SetCCodCli( trim($_POST['ccodcli']) );
        $class_insert->SetCRazon(trim($crazon));
        $class_insert->SetCNombre1(trim($_POST['cnombre1']));
        $class_insert->SetCNombre2(trim($_POST['cnombre2']));
        $class_insert->SetCPaterno(trim($_POST['cpaterno']));
        $class_insert->SetCMaterno(trim($_POST['cmaterno']));
        $class_insert->SetCDireccion(trim($_POST['cdireccion']));
        $class_insert->SetCTelefono1(trim($_POST['ctelefono1']));
        $class_insert->SetCTelefono2(trim($_POST['ctelefono2']));
        $class_insert->SetCCorreo(trim($_POST['ccorreo']));
        $checkinsert = $class_insert->insertClient();
        if($checkinsert){
            $arrayName = array( 'status' => true, 'crazon' => $crazon, 'ccodcli' => $_POST['ccodcli'], 'message' => 'Cliente Registrado.' );
            echo json_encode($arrayName);
            exit();
        } else {
            $arrayName = array( 'status' => false, 'resulthtml' => 'Registro Incorrecto.' );
            echo json_encode($arrayName);
            exit();
        }
    }
    if($_POST['typeregister'] === 'savecompanie'){
        validateinputs();
        $class_insert->SetCCodCli(trim($_POST['ccodcli']));
        $class_insert->SetCRazon(trim($_POST['crazon']));
        $class_insert->SetCNombre1(trim($_POST['cnombre1']));
        $class_insert->SetCNombre2(trim($_POST['cnombre2']));
        $class_insert->SetCPaterno(trim($_POST['cpaterno']));
        $class_insert->SetCMaterno(trim($_POST['cmaterno']));
        $class_insert->SetCDireccion(trim($_POST['cdireccion']));
        $class_insert->SetCTelefono1(trim($_POST['ctelefono1']));
        $class_insert->SetCTelefono2(trim($_POST['ctelefono2']));
        $class_insert->SetCCorreo(trim($_POST['ccorreo']));
        $checkinsert = $class_insert->insertClient();
        if($checkinsert){
            $arrayName = array( 'status' => true, 'crazon' => $_POST['crazon'], 'ccodcli' => $_POST['ccodcli'], 'message' => 'Cliente Registrado.' );
            echo json_encode($arrayName);
            exit();
        } else {
            $arrayName = array( 'status' => false, 'message' => 'Registro Incorrecto.' );
            echo json_encode($arrayName);
            exit();
        }
    }

}

?>
