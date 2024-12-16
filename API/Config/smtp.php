<?php
  include "../../Config/config.php";
  require "../../Controllers/ConfigController/smtpController.php";
   
    
    $obj = new smtpController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
        
        
        switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            echo $obj->createSmtp($input);
          break;
          case "GET":
            if(isset($_GET["id"])){
              echo $obj->showSmtpOnly($_GET['id']);
            }else{
             
              echo $obj->showSmtp();
            }
          break;
          case "PATCH":
            if(isset($_GET["id"])){
              echo $obj->removeSmtp($_GET['id']);
            }else{
                echo $obj->changeSmtp($input);
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
    