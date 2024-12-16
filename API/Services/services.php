 
<?php
include '../../Controllers/ServicesController/servicesControllers.php';
include '../../Config/config.php';

$obj = new servicesControllers();

try{
$input = json_decode(file_get_contents("php://input"),true);

switch($_SERVER["REQUEST_METHOD"]){
  case "POST" :
    	echo $obj->createService($input);
  break;
  case "GET":
    if(isset($_GET["cve"])){
    echo $obj->showService($_GET["cve"]);
    }else{
      if(isset($_GET["identificador"])){
        echo $obj->showViewService($_GET["identificador"],$_GET["contador"],$_GET["condicion"]);
      }else{
        if(isset($_GET["identificadorUltimo"]))
        {
          echo $obj->showService_maxIdFalso($_GET["identificadorUltimo"]);
        }else{
          echo $obj->showServiceIdMax();
        }
      }
    }
  break;
  case "PATCH":
    if(isset($_GET["cve"])){		
      echo $obj->deleteChangeService($_GET["cve"]);
    }else{		
      echo $obj->changeService($input);
    }
  break;
  case "DELETE":

  break;
}
}catch(Exception $e){
  echo json_encode(array('status'=> "error",
	"info" => "error server",
	"container" => $e));
}



