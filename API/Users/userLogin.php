<?php
include "../../Config/Config.php";
include "../../Controllers/UsersController/userLoginController.php";

$obj = new userLoginController();

try{
$input = json_decode(file_get_contents('php://input'),true);
switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
            echo $obj->userLogin($_GET['usuario'],$_GET['contrasena'],$_GET['tipo']);
        break;
    case 'PATCH':
        if(isset($input['nivel'])){
            echo $obj->userLoginLevel($input);
        }else{
            echo $obj->userLoginPass($input);
        }
        break;
}
}catch(Exception $e){
    $dbcon = null; 
    echo  json_encode(array('status'=>"error",
    'info'=>"error server",
    'container'=>$e));
}
?>