<?php
  include "../../Config/config.php";
  require "../../Controllers/DevicesController/routerController.php";
   
    
    $obj = new routerController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
        
        
        switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            if(isset($input["cve2"])){
              echo $obj->createRouter2($input);
            }else{
              echo $obj->createRouter($input);
            }
          break;
          case "GET":
            if(isset($_GET["id"])){
              echo $obj->showRouterOnly($_GET['id']);
            }else{
              if(isset($_GET["identificador"])){
                echo $obj->showRouter($_GET["identificador"], $_GET["contador"],$_GET["condicion"],$_GET["iddevice"]);
              }else{
                echo $obj->showAutoIncrement();
              } 
            }
          break;
          case "PATCH":
            echo $obj->changeRouter($input);
          break;
          case "DELETE":
            if(isset($_GET['id'])){
              echo $obj->removeRouter($_GET['id']);
            }else{
              echo $obj->updateRouter2($_GET['cve2']);
            }
          break;
        }
        }catch(Exception $e){
          echo json_encode(array('status'=> "error",
            "info" => "error server",
            "container" => $e));
        }
    