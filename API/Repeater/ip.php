<?php
include '../../Controllers/RepeaterController/ipController.php';
include '../../Config/config.php';

$obj = new ipController();

try{
$input = json_decode(file_get_contents("php://input"),true);

switch($_SERVER["REQUEST_METHOD"]){
  case "POST":
    echo $obj->createIp($input);
  break;
  case "GET":
  if(isset($_GET["segmentoBuscarSinParam"])){
    echo $obj->showIpOnlySinParam($_GET["segmentoBuscarSinParam"]);
  }else if(isset($_GET["segmentoBuscar"])){
    echo $obj->showIpOnly($_GET["segmento"],$_GET["segmentoFinal"],$_GET["segmentoBuscar"]);
  }else if(isset($_GET['segmento']) && isset($_GET["segmentoFinal"])){
    echo $obj->showIp($_GET["segmento"],$_GET["segmentoFinal"], $_GET["condicion"],$_GET["condicion2"]);
  }else if(isset($_GET["cveSegmento"])) {
    echo $obj->countActiveIpSegmento($_GET["cveSegmento"]);
  }else {
 	  echo $obj->showIps();
  }
  break;
  case "PATCH":
  break;
  case "DELETE":

  break;
}
}catch(Exception $e){
  echo json_encode(array('status'=> "error",
	"info" => "error server",
	"container" => $e));
}

