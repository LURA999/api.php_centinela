<?php
  include "../../Config/config.php";
  require "../../Controllers/ManualController/manualController.php";
   
    
    $obj = new manualController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
         switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            echo $obj->createManual($input);
          break;
          case "GET":
            if(isset($_GET["user"])){
              echo $obj->showManualby();
            }else if(isset($_GET["count"])){
              echo $obj->showManualbycount();
            }else
            {
              echo $obj->showManual();

            }
          break;
          case "PATCH":
                echo $obj->changeManual($input);
          
          break;
          case "DELETE":
            echo $obj->removeManual($_GET["id"]);

          break;
        }
        }catch(Exception $e){
          echo json_encode(array('status'=> "error",
            "info" => "error server",
            "container" => $e));
        }
    