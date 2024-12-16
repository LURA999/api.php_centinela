<?php
include '../../Controllers/ServicesController/rsControllers.php';
include '../../Config/config.php';

$obj = new rsControllers();

try{
$input = json_decode(file_get_contents("php://input"),true);

switch($_SERVER["REQUEST_METHOD"]){
  case "POST":
    	echo $obj->createRS($input);
  break;
  case "GET":
    if(isset($_GET["cve"])){
	    echo $obj->showRS($_GET["cve"]);
    }else{
	    echo $obj->showRS($_GET["cve2"]);
    }
  break;
  case "PATCH":
    if(isset($_GET["cve"])){		
      echo $obj->deleteChangeRS($_GET["cve"]);
    }else{		
      echo $obj->changeRS($input);
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




