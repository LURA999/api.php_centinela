<?php
include '../../Controllers/RepeaterController/repeaterController.php';
include '../../Config/config.php';

$obj = new repeaterController();

try{
$input = json_decode(file_get_contents("php://input"),true);


switch($_SERVER["REQUEST_METHOD"]){
  case "POST":
    echo $obj->createRepeater($input);
  break;
  case "GET":
    if(isset($_GET["id"])){
      echo $obj->showRepeaterOnly($_GET['id']);
    }else{
	if(isset($_GET["cve"])){
		echo $obj-> showAllRepeater($_GET["cve"]);
	}else{
    if(isset($_GET["idr"]) && !isset($_GET["tipo"])){
      echo $obj->showSegmentRepeater($_GET["idr"]);
    }else{
      if(isset($_GET["tipo"]) && !isset($_GET["idr"])){
        echo $obj->showRepeater($_GET["tipo"]);
      }else if(isset($_GET["idr"]) && isset($_GET["tipo"])) {
        echo $obj->showSegmentRepeaterTipo($_GET["idr"],$_GET["tipo"]); 
      }else{
        echo $obj->showRepeater2();
      }
    }
	}
    }
  break;
  case "PATCH":
    if(isset($_GET["id"])){
      echo $obj->removeRepeater($_GET['id']);
    }else{
	    echo $obj->changeRepeater($input);
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




