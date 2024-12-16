<?php
include '../../Controllers/TicketsController/ticketsController.php';
include '../../Config/config.php';

$obj = new ticketsController();

try{
$input = json_decode(file_get_contents("php://input"),true);

switch($_SERVER["REQUEST_METHOD"]){
  case "POST":
  if(isset($input["comentario"])){
    echo $obj->insertComment($input);
  }else{    
    echo $obj->createTicket($input);
  }
  break;
  case "GET":
    if(isset($_GET['historial'])){
      echo $obj->showAllHistorial($_GET['historial']);
    }else if(isset($_GET['cve']) && !isset($_GET['cond']) && !isset($_GET['identificador']) ){
      echo $obj->showOneTicket($_GET['cve']);
    }else if(isset($_GET['cve']) && !isset($_GET['cond'])){
	    echo $obj->showTicketCustomer($_GET['cve'],$_GET["identificador"]);
    }else{
      echo $obj->showTicket($_GET['cond'],isset($_GET['cve']));
    }
  break;
  case "PATCH":
	if(isset($_GET['cve'])){
	  echo $obj->changeDeleteTicket($_GET['cve']);
	}else if(isset($_GET['ticket'])){
	  echo $obj->changeTicket($input);
	}else if(isset($_GET['estado'])){
	  echo $obj->changeEstate($input);
	}else if(isset($_GET['propiedad'])){
	  echo $obj->changeProperty($input);
	}else if(isset($_GET['grupo'])){
	  echo $obj->changeGroup($input);
  }else if(isset($_GET['agente'])){
	  echo $obj->changeAgente($input);
  }else if(isset($_GET['tipo'])){
	  echo $obj->changeType($input);
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

