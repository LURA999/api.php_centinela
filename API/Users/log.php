<?php
include '../../Controllers/UsersController/logController.php';
include '../../Config/config.php';

$obj = new logController();

try{
$input = json_decode(file_get_contents("php://input"),true);

switch($_SERVER["REQUEST_METHOD"]){
  case "POST":
    	echo $obj->createLog($input);
  break;
  case "GET":
	echo $obj->showLog($_GET['cve']);
  break;
  case "PATCH":
  if(isset($_GET['cve'])){
      echo $obj->deleteChangeLog($_GET['cve']);
  }else{
	  echo $obj->changeLog($input);
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

