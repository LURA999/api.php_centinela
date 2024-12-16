<?php
include '../../Controllers/ServicesController/contactsControllers.php';
include '../../Config/config.php';

$obj = new contactsControllers();

try{

$input = json_decode(file_get_contents("php://input"),true);
switch($_SERVER["REQUEST_METHOD"]){
  case "POST":
    if(isset($input["cveRol"])){
    	echo $obj->createContact($input);
    }else{
      echo $obj->createDetailContact($input);
    }
  break;
  case "GET":
    if(isset($_GET["cve"])&& !isset($_GET["contador"]) ){
      echo $obj->showContact($_GET["cve"]);
    }else{
      if(isset($_GET["cveCliente"]) && !isset($_GET["identificador"])){
        echo $obj->showContactServices($_GET["cveCliente"]);
      }else{
        if(isset($_GET["cveCliente"]) && isset($_GET["identificador"])){
          echo $obj->showContactos_Servicios($_GET["cveCliente"], $_GET["identificador"]);
        }else{
          if(isset($_GET["identificador"]) && isset($_GET["idContacto"])& isset($_GET["condicion"])){
            echo $obj->showServicePerContacto($_GET["identificador"], $_GET["idContacto"], $_GET["condicion"]);
          }else{
            if(isset($_GET["cve"])&&isset($_GET["contador"])){
              echo $obj->showContactosOnlyServicio($_GET["cve"],$_GET["contador"],$_GET["condicion"],$_GET["identificador"]);
            }else{
              echo $obj->showContactIdMax();
            }
          }
        }
      }
    }
  break;
  case "PATCH":
	if(isset($_GET["cve"])){		
    echo $obj->deleteChangecontacts($_GET["cve"]);
	}else{		
    echo $obj->changeContact($input);
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


