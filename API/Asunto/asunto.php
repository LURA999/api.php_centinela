<?php
  include "../../Config/config.php";
  require "../../Controllers/AsuntoController/asuntoController.php";
   
    
    $obj = new asuntoController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
        
        
        switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            echo $obj->createAsunto($input);
          break;
          case "GET":
        
             
              echo $obj->showAsunto();
            
          break;
          case "PATCH":
            echo ("");
                echo $obj->changeAsunto($input);
          
          break;
          case "DELETE":
            echo $obj->removeAsunto($_GET["id"]);

          break;
        }
        }catch(Exception $e){
          echo json_encode(array('status'=> "error",
            "info" => "error server",
            "container" => $e));
        }
    