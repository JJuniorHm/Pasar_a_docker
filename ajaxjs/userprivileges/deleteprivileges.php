<?php

include "../../csses/userprivileges/userprivileges.php";

$Add_Privileges = new Add_Privileges();

$Add_Privileges->setPlatform($_POST['platform']);
$Add_Privileges->setModule($_POST['mdle']);
$Add_Privileges->setCodUser($_POST['ucoduser']);

$checkexist = $Add_Privileges->exist_UserPrivilege();
if($checkexist->num_rows == 1){
    $check = $Add_Privileges->delete_UserPrivilege();
    if($check){
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
        echo json_encode(array('data' => 'Privilegio Concedido.', 'html' => $table_userprivileges));
    }else{
        echo json_encode(array('data' => 'A ocurrido algo al intentar dar Privilegios.'));
    }
}else{
    echo json_encode(array('data' => 'No hay necesidad de volver a dar los privilegios..'));
}


?>