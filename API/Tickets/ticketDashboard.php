<?php
include '../../Controllers/ticketsController/ticketControllerDashboard.php';
require '../../Config/config.php';

$obj = new ticketControllerDashboard();

try{
    $input = json_decode(file_get_contents("php://input"),true);
    
    switch($_SERVER["REQUEST_METHOD"]){
      case "GET":

        if(isset($_GET["fechaInicio"]) && isset($_GET["fechaFin"]) && isset($_GET["tipo"])){
            $obj->selectType($_GET["fechaInicio"],$_GET["fechaFin"],$_GET["tipo"],$_GET["grupo"]);
        }else{
          $obj->selectTicket($_GET["fechaInicio"],$_GET["fechaFin"],$_GET["filtro"],$_GET["empresa"],$_GET["grupo"]);
        }
        break;
      }
    }catch(Exception $e){
        echo json_encode(array('status'=>"error",
        "info"=> "error en el server",
        "content"=> $e));
    }
