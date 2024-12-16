<?php
include "../../Config/Config.php";
include "../../Controllers/CustomerController/rolController.php";

$obj = new rolController();

try{
$input = json_decode(file_get_contents('php://input'),true);
switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
            echo $obj->listRol();
        break;
    case 'POST':
 	echo $obj->insertRol($input);
        break;
    case 'PATCH':
	if(isset($_GET['id'])){
	    echo $obj->eliminarFalso($_GET['id']);
	}else{
        echo $obj->actualizarRol($input);
	}
	break;
}
}catch(Exception $e){
    $dbcon = null; 
    echo  json_encode(array('status'=>"error",
    'info'=>"error server",
    'container'=>$e));
}

