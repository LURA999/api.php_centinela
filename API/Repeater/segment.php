<?php
include "../../Config/config.php";
include "../../Controllers/RepeaterController/segmentController.php";

$obj = new segmentController();

try{
$input = json_decode(file_get_contents("php://input"),true);
switch($_SERVER["REQUEST_METHOD"]){
  case "POST":
        echo $obj->createSegment($input);
  break;
  case "GET":
    if(isset($_GET["segmento"])){
  	  echo $obj->showExist($_GET["segmento"]);
    }else if(isset($_GET["last"])){
        echo $obj->lastSegmento();  
      }else{
	echo $obj->showSegment();
    }
  break;
  case "PATCH":
    if(isset($_GET['id'])){
	echo $obj->updateElimSegment($_GET['id']);
    }else{
        echo $obj->actualizarSegment($input);
    }
   break;
  case "DELETE":
	echo $obj->removeSegment($cve);
  break;
}

}catch(Exception $e){
  echo json_encode(array('status'=> "error",
	"info" => "error server",
	"container" => $e));
}