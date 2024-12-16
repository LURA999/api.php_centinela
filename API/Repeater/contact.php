<?php
include '../../Controllers/RepeaterController/contactController.php';
include '../../Config/config.php';

$obj = new contactController();

try{
$input = json_decode(file_get_contents("php://input"),true);


switch($_SERVER["REQUEST_METHOD"]){
  case "POST":
    echo $obj->createContact($input);
  break;
  case "GET":
  	echo $obj->showContact($_GET["id"]);
  break;
  case "PATCH":
    if(isset($_GET["id"])){
      echo $obj->removeContact($_GET['id']);
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

