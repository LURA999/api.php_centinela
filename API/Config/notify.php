<?php
  include "../../Config/config.php";
  require "../../Controllers/ConfigController/notifyController.php";
   
    
    $obj = new notifyController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
        
        
        switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            echo $obj->createNotify($input);
          break;
          case "GET":
           
              echo $obj->showNotify();
            
          break;
          case "PATCH":
            if(isset($input["correo_pago"])){
              echo $obj->changeNotification($input);
            }else{

                echo $obj->changeNotify($input);
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
    