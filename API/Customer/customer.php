<?php
include "../../Config/Config.php";
include "../../Controllers/CustomerController/customerController.php";

$obj = new customerController();

try{
$input = json_decode(file_get_contents('php://input'),true);
switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
	if(isset($_GET['opc'])){
            echo $obj->listCustomer($_GET['opc']);
	}else if(isset($_GET['nombre'])){
	    echo $obj->countNombre($_GET['nombre']);
	}else{
        if(isset($_GET["cve"])){
            echo $obj->searchCustomer($_GET['cve']);
        }else{
            echo $obj->listCustomerAll();
        }
    }
        break;
    case 'POST':
            echo $obj->insertCustomer($input);
        break;
    case 'PATCH':
	if(isset($_GET['id'])){
	    echo $obj->eliminarFalso($_GET['id']);
	}else{
        echo $obj->actualizarCliente($input);
	}
	break;
}
}catch(Exception $e){
    $dbcon = null; 
    echo  json_encode(array('status'=>"error",
    'info'=>"error server",
    'container'=>$e));
}

