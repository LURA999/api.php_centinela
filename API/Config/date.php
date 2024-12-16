<?php
  include "../../Config/config.php";
  require "../../Controllers/ConfigController/dateController.php";
   
    
    $obj = new dateController();

    try{
        $input = json_decode(file_get_contents("php://input"),true);
        
        
        switch($_SERVER["REQUEST_METHOD"]){
          case "POST":
            echo $obj->createDate($input);
          break;
          case "GET":
            if(isset($_GET["id"])){
              echo $obj->showDateOnly($_GET['id']);
            }else{
             
              echo $obj->showDate();
            }
          break;
          case "PATCH":
            
                echo $obj->changeDate ($input);
            
          break;
          case "DELETE":
        
          break;
        }
        }catch(Exception $e){
          echo json_encode(array('status'=> "error",
            "info" => "error server",
            "container" => $e));
        }
    