<?php
  include "../../Config/config.php";
  require "../../Controllers/DevicesController/othersController.php";
   
    
    $obj = new othersController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
        
        
        switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            if(isset($input["cve2"])){
              echo $obj->createOthers2($input);
            }else{
              echo $obj->createOthers($input);
            }
          break;
          case "GET":
            if(isset($_GET["id"])){
              echo $obj->showOthersOnly($_GET['id']);
            }else{
              if(isset($_GET["identificador"])){
                echo $obj->showOthers($_GET["identificador"], $_GET["contador"],$_GET["condicion"],$_GET["iddevice"]);
              }else{
                echo $obj->showAutoIncrement();
              } 
            }
          break;
          case "PATCH":
            echo $obj->changeOthers($input);
          break;
          case "DELETE":
            if(isset($_GET['id'])){
              echo $obj->removeOthers($_GET['id']);
            }else{
              echo $obj->updateOthers2($_GET['cve2']);
            }         
            break;
          }
        }catch(Exception $e){
          echo json_encode(array('status'=> "error",
            "info" => "error server",
            "container" => $e));
        }
    