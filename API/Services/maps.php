<?php
include '../../Controllers/ServicesController/mapsControllers.php';
include '../../Config/config.php';

$obj = new mapsControllers();

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
    echo $obj->showMaps();
  break;
  case "PATCH":
    echo $obj->changeMaps($input);
  break;
  case "DELETE":
  break;
}
}catch(Exception $e){
  echo json_encode(array('status'=> "error",
	"info" => "error server",
	"container" => $e));
}


